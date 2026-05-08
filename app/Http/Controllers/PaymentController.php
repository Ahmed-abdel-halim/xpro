<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use App\Services\PaymobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paymob;

    public function __construct(PaymobService $paymob)
    {
        $this->paymob = $paymob;
    }

    /**
     * Show selection page for payment method (Card or Wallet)
     */
    public function checkout(Course $course)
    {
        $user = auth()->user();

        // Check if student is already enrolled
        if ($user->enrolledCourses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('course.show', $course->id)->with('info', 'أنت مشترك بالفعل في هذا الكورس.');
        }

        // Check if there is a pending payment to avoid double payment
        $pendingPayment = Payment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'pending')
            ->first();

        return view('payments.checkout', compact('course', 'pendingPayment'));
    }

    /**
     * Show traditional payment form
     */
    public function traditionalPayment(Course $course)
    {
        return view('payments.traditional', compact('course'));
    }

    /**
     * Process traditional payment
     */
    public function processTraditionalPayment(Request $request, Course $course)
    {
        $request->validate([
            'payment_method' => 'required|in:wallet,instapay,bank_transfer',
            'sender_number' => 'required|string|max:255',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();

        // Handle proof image upload
        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            $file = $request->file('proof_image');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $proofPath = $file->storeAs('payments/proofs', $filename, 'public');
        }

        // Calculate Commission
        $teacher = $course->teacher;
        $teacherAmount = $course->price * $teacher->getTeacherRate();
        $commissionAmount = $course->price - $teacherAmount;

        // Create payment record
        $payment = Payment::create([
            'student_id' => $user->id,
            'teacher_id' => $course->teacher_id,
            'course_id' => $course->id,
            'amount' => $course->price,
            'payment_method' => $request->payment_method,
            'sender_number' => $request->sender_number,
            'proof_image' => $proofPath,
            'notes' => $request->notes,
            'payment_date' => $request->payment_date,
            'status' => 'pending',
            'commission_amount' => $commissionAmount,
            'teacher_amount' => $teacherAmount,
        ]);

        // Notify teacher
        try {
            $course->teacher->notify(new \App\Notifications\NewPaymentReceived($payment));
        } catch (\Exception $e) {
            Log::error('Failed to notify teacher: ' . $e->getMessage());
        }

        return redirect()->route('payment.success', $payment->id)
            ->with('success', 'تم إرسال طلب الدفع بنجاح. سيقوم المدرس بمراجعة التحويل وتفعيل الكورس لك قريباً.');
    }

    /**
     * Show payment success page
     */
    public function paymentSuccess(Payment $payment)
    {
        return view('payments.success', compact('payment'));
    }

    /**
     * Teacher dashboard for payments
     */
    public function teacherPayments()
    {
        $user = auth()->user();
        $payments = $user->receivedPayments()->with(['student', 'course'])->latest()->paginate(20);
        
        return view('payments.teacher-dashboard', compact('payments'));
    }

    /**
     * Confirm payment (by teacher)
     */
    public function confirmPayment(Request $request, Payment $payment)
    {
        // Manual authorization check
        if (auth()->id() !== $payment->teacher_id && !auth()->user()->isAdmin()) {
            abort(403, 'غير مصرح لك بتأكيد هذه الدفعة.');
        }
        
        // Ensure commission is calculated if it wasn't during creation
        if (!$payment->commission_amount || !$payment->teacher_amount) {
            $teacher = $payment->teacher;
            $teacherAmount = $payment->amount * $teacher->getTeacherRate();
            $commissionAmount = $payment->amount - $teacherAmount;
            
            $payment->commission_amount = $commissionAmount;
            $payment->teacher_amount = $teacherAmount;
        }

        $payment->status = 'confirmed';
        $payment->confirmed_at = now();
        $payment->save();

        // Enroll student in course
        $payment->student->enrolledCourses()->attach($payment->course_id);

        // Notify student
        $payment->student->notify(new \App\Notifications\PaymentConfirmed($payment));

        return redirect()->route('payments.teacher')->with('success', 'تم تأكيد الدفع وتفعيل الكورس للطالب.');
    }

    /**
     * Student payment history
     */
    public function studentPayments()
    {
        $user = auth()->user();
        $payments = $user->payments()->with(['teacher', 'course'])->latest()->paginate(20);
        
        return view('payments.student-history', compact('payments'));
    }


    /**
     * Process payment based on selected method
     */
    public function process(Request $request, Course $course)
    {
        $method = $request->input('method'); // 'card' or 'wallet'
        $user = auth()->user();

        // 1. Check if already enrolled
        if ($user->enrolledCourses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('course.show', $course->id)->with('info', 'أنت مشترك بالفعل في هذا الكورس.');
        }

        // 2. Check for existing pending payment to prevent multiple orders
        $existingPayment = Payment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'pending')
            ->first();

        // 1. Authenticate with Paymob
        $authToken = $this->paymob->authenticate();
        if (!$authToken) {
            return back()->with('error', 'Authentication failed with payment gateway.');
        }

        // 2. Register Order
        $order = $this->paymob->createOrder($authToken, $course->price, "COURSE_{$course->id}_USER_{$user->id}_" . time());
        if (!isset($order['id'])) {
            return back()->with('error', 'Order registration failed.');
        }

        // 3. Calculate Commission
        $teacher = $course->teacher;
        $teacherAmount = $course->price * $teacher->getTeacherRate();
        $commissionAmount = $course->price - $teacherAmount;

        // 4. Create or Update Pending Payment Record
        if ($existingPayment) {
            $existingPayment->update([
                'transaction_id' => $order['id'],
                'payment_method' => $method === 'card' ? 'Paymob Card' : 'Paymob Wallet',
            ]);
            $payment = $existingPayment;
        } else {
            $payment = Payment::create([
                'student_id' => $user->id,
                'course_id' => $course->id,
                'amount' => $course->price,
                'payment_method' => $method === 'card' ? 'Paymob Card' : 'Paymob Wallet',
                'transaction_id' => $order['id'],
                'status' => 'pending',
                'commission_amount' => $commissionAmount,
                'teacher_amount' => $teacherAmount,
            ]);
        }

        // 5. Get Payment Key
        $integrationId = match($method) {
            'card' => env('PAYMOB_INTEGRATION_ID_CARD'),
            'wallet' => env('PAYMOB_INTEGRATION_ID_WALLET'),
            'kiosk' => env('PAYMOB_INTEGRATION_ID_KIOSK'),
            default => env('PAYMOB_INTEGRATION_ID_CARD'),
        };

        $billingData = [
            'first_name' => explode(' ', $user->name)[0] ?: $user->name,
            'last_name' => explode(' ', $user->name)[1] ?? 'NA',
            'email' => $user->email,
            'phone_number' => $user->phone ?? '01000000000',
            'street' => 'NA',
            'building' => 'NA',
            'floor' => 'NA',
            'apartment' => 'NA',
            'city' => 'NA',
            'state' => 'NA',
            'country' => 'NA',
            'postal_code' => 'NA',
            'extra_description' => 'NA',
        ];

        $paymentKey = $this->paymob->getPaymentKey($authToken, $course->price, $order['id'], $billingData, $integrationId);

        if (!$paymentKey) {
            return back()->with('error', 'Failed to generate payment key.');
        }

        // 6. Redirect to Paymob
        $baseUrl = env('PAYMOB_BASE_URL', 'https://accept.paymob.com/api');

        if ($method === 'card') {
            $iframeId = env('PAYMOB_IFRAME_ID');
            return redirect("{$baseUrl}/acceptance/iframes/{$iframeId}?payment_token={$paymentKey}");
        } elseif ($method === 'wallet') {
            $phone = $request->wallet_phone ?? ($user->phone ?? '01000000000');
            $phone = preg_replace('/[^0-9]/', '', $phone);
            if (strlen($phone) > 11) {
                $phone = substr($phone, -11);
            }

            $walletResponse = $this->paymob->prepareWalletPayment($paymentKey, $phone);
            
            Log::info('Paymob Wallet Response:', $walletResponse);

            if (isset($walletResponse['redirect_url']) && $walletResponse['redirect_url'] !== "") {
                return redirect($walletResponse['redirect_url']);
            }

            $payment->delete();

            if (isset($walletResponse['data']['message'])) {
                return back()->with('error', 'Paymob Error: ' . $walletResponse['data']['message'] . ' (نصيحة: جرب استخدام رقم 01010101010 في بيئة الاختبار)');
            }

            return back()->with('error', 'Failed to initiate wallet payment. Please make sure the phone number is registered as a wallet.');
        } else {
            // Kiosk
            $kioskResponse = $this->paymob->prepareKioskPayment($paymentKey);
            Log::info('Paymob Kiosk Response:', $kioskResponse);

            if (isset($kioskResponse['data']['bill_reference'])) {
                return redirect()->route('payment.kiosk', ['bill_reference' => $kioskResponse['data']['bill_reference']]);
            }

            $payment->delete();
            return back()->with('error', 'Failed to initiate Kiosk payment.');
        }
    }

    /**
     * Show the Kiosk payment code
     */
    public function kiosk($bill_reference)
    {
        return view('payments.kiosk', compact('bill_reference'));
    }

    /**
     * Webhook for Paymob to notify about transaction status
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();
        Log::info('Paymob Webhook Received:', $payload);

        $orderId = $payload['obj']['order']['id'] ?? null;
        $success = $payload['obj']['success'] ?? false;
        $transactionId = $payload['obj']['id'] ?? null;
        
        if ($orderId) {
            $payment = Payment::where('transaction_id', $orderId)->first();
            
            if ($payment && $payment->status === 'pending') {
                if ($success) {
                    $payment->update([
                        'status' => 'completed',
                        // We keep the Order ID in transaction_id for lookup but we can log the real trans ID
                    ]);
                    
                    // Enroll Student
                    $payment->student->enrolledCourses()->syncWithoutDetaching([$payment->course_id]);
                    Log::info("Payment Successful for Order {$orderId} via Webhook");
                } else {
                    $payment->update(['status' => 'failed']);
                    Log::warning("Payment Failed for Order {$orderId} via Webhook");
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Callback for redirection after payment
     */
    public function callback(Request $request)
    {
        Log::info('Paymob Callback Params:', $request->all());

        $success = $request->query('success');
        $orderId = $request->query('order'); // Paymob's internal Order ID
        $merchantOrderId = $request->query('merchant_order_id'); // Our custom ID
        $user = auth()->user();
        
        $isSuccessful = ($success === 'true' || $success === '1' || $success === true || $success == 1);

        if ($isSuccessful) {
            $payment = null;
            
            // 1. Try finding by Paymob Order ID
            if ($orderId) {
                $payment = Payment::where('transaction_id', $orderId)->first();
            }
            
            // 2. Fallback: If logged in, find the user's latest pending payment
            // This is very reliable for local testing 
            if (!$payment && $user) {
                $payment = Payment::where('student_id', $user->id)
                    ->where('status', 'pending')
                    ->latest()
                    ->first();
            }

            // 3. Last fallback: try parsing merchant_order_id if present
            if (!$payment && $merchantOrderId) {
                if (preg_match('/COURSE_(\d+)_USER_(\d+)_/', $merchantOrderId, $matches)) {
                    $courseId = $matches[1];
                    $userId = $matches[2];
                    $payment = Payment::where('student_id', $userId)
                        ->where('course_id', $courseId)
                        ->where('status', 'pending')
                        ->latest()
                        ->first();
                }
            }
            
            if ($payment) {
                $payment->update([
                    'status' => 'completed',
                    'payment_method' => $payment->payment_method ?: 'Paymob',
                ]);
                
                // Ensure Enrollment
                $payment->student->enrolledCourses()->syncWithoutDetaching([$payment->course_id]);
                
                Log::info("Payment AUTO-COMPLETED for Payment ID: {$payment->id}");

                return redirect()->route('dashboard')->with('success', 'تمت عملية الدفع بنجاح! مبروك، الكورس متاح لك الآن.');
            }
        }

        // Even if we couldn't find the payment record but Paymob says success, the user should be happy
        if ($isSuccessful) {
             return redirect()->route('dashboard')->with('success', 'تمت عملية الدفع بنجاح! يمكنك البدء بالتعلم.');
        }

        return redirect()->route('home')->with('error', 'عذراً، لم تكتمل عملية الدفع بشكل صحيح.');
    }
}
