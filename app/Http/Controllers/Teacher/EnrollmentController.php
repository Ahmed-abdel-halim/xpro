<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnrollmentController extends Controller
{
    /**
     * Show the form to manually enroll a student.
     */
    public function create()
    {
        // Get all courses belonging to this teacher
        $courses = auth()->user()->courses()->latest()->get();

        return view('teacher.courses.enroll-student', compact('courses'));
    }

    /**
     * Store the manual enrollment in the database.
     */
    public function store(Request $request)
    {
        $teacher = auth()->user();

        $request->validate([
            'student_identifier' => 'required|string|max:255',
            'course_id' => [
                'required',
                'exists:courses,id',
                function ($attribute, $value, $fail) use ($teacher) {
                    $course = Course::find($value);
                    if ($course && $course->teacher_id !== $teacher->id) {
                        $fail('هذا الكورس لا يخصك.');
                    }
                },
            ],
        ]);

        $identifier = trim($request->student_identifier);
        $courseId = $request->course_id;

        // Search for a student by email or phone number
        $student = User::where('role', 'student')
            ->where(function ($query) use ($identifier) {
                $query->where('email', $identifier)
                      ->orWhere('phone', $identifier);
            })
            ->first();

        if (!$student) {
            return back()->withInput()->with('error', 'عذراً، لم نجد طالباً مسجلاً بهذا البريد الإلكتروني أو رقم الهاتف. يرجى التأكد من تسجيل الطالب في المنصة أولاً.');
        }

        // Check if student is already enrolled in this course
        if ($student->enrolledCourses()->where('course_id', $courseId)->exists()) {
            return back()->withInput()->with('error', 'هذا الطالب مشترك بالفعل في هذا الكورس.');
        }

        $course = Course::findOrFail($courseId);

        // Calculate Commission & Teacher Amount
        $teacherRate = $teacher->getTeacherRate();
        $teacherAmount = $course->price * $teacherRate;
        $commissionAmount = $course->price - $teacherAmount;

        DB::beginTransaction();
        try {
            // Create a confirmed payment record for the manual cash transaction
            $payment = Payment::create([
                'student_id' => $student->id,
                'teacher_id' => $teacher->id,
                'course_id' => $course->id,
                'amount' => $course->price,
                'payment_method' => 'cash_by_teacher',
                'notes' => 'تفعيل يدوي من قبل المعلم (دفع نقدي/كاش مباشر)',
                'status' => 'confirmed',
                'payment_date' => now(),
                'confirmed_at' => now(),
                'commission_amount' => $commissionAmount,
                'teacher_amount' => $teacherAmount,
            ]);

            // Enroll student in the course
            $student->enrolledCourses()->attach($course->id);

            DB::commit();

            // Notify student
            try {
                $student->notify(new \App\Notifications\PaymentConfirmed($payment));
            } catch (\Exception $e) {
                Log::error('Failed to notify student on manual enrollment: ' . $e->getMessage());
            }

            return redirect()->route('teacher.dashboard')->with('success', 'تم تفعيل الكورس للطالب ' . $student->name . ' بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Manual enrollment failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'حدث خطأ أثناء تفعيل الكورس للطالب. يرجى المحاولة مرة أخرى.');
        }
    }
}
