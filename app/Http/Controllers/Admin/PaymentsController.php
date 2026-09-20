<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * إدارة الدفعات من جانب الشركة (الأدمن).
 * الدفع يذهب للشركة، والأدمن يؤكد الدفع ويُفعّل الكورس للطالب.
 * المدرس يرى رصيده فقط ويطلب سحبه.
 */
class PaymentsController extends Controller
{
    public function index()
    {
        $pendingPayments = Payment::with(['student', 'teacher', 'course'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $confirmedPayments = Payment::with(['student', 'teacher', 'course'])
            ->where('status', 'confirmed')
            ->latest()
            ->take(50)
            ->get();

        $stats = [
            'pending_count'   => $pendingPayments->count(),
            'pending_amount'  => $pendingPayments->sum('amount'),
            'confirmed_today' => Payment::where('status', 'confirmed')
                ->whereDate('confirmed_at', today())->count(),
            'total_revenue'   => Payment::whereIn('status', ['confirmed', 'completed'])->sum('amount'),
        ];

        return view('admin.payments.index', compact('pendingPayments', 'confirmedPayments', 'stats'));
    }

    /** الأدمن يؤكد الدفع → يُفعَّل الكورس للطالب */
    public function confirm(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'هذه الدفعة ليست في حالة انتظار.');
        }

        // حساب العمولة إذا لم تُحسب
        if (!$payment->commission_amount) {
            $teacher = $payment->teacher;
            $teacherAmount    = $payment->amount * ($teacher?->getTeacherRate() ?? 0.8);
            $commissionAmount = $payment->amount - $teacherAmount;
            $payment->teacher_amount    = $teacherAmount;
            $payment->commission_amount = $commissionAmount;
        }

        $payment->status       = 'confirmed';
        $payment->confirmed_at = now();
        $payment->save();

        // تسجيل الطالب في الكورس
        $payment->student->enrolledCourses()->syncWithoutDetaching([$payment->course_id]);

        // إشعار الطالب
        try {
            $payment->student->notify(new \App\Notifications\PaymentConfirmed($payment));
        } catch (\Exception $e) {
            \Log::error('Failed to notify student: ' . $e->getMessage());
        }

        return back()->with('success', 'تم تأكيد الدفعة وتفعيل الكورس للطالب: ' . $payment->student->name);
    }

    /** رفض الدفعة */
    public function reject(Request $request, Payment $payment)
    {
        $payment->update(['status' => 'failed']);
        return back()->with('success', 'تم رفض الدفعة.');
    }
}
