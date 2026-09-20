<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Grade;
use App\Models\Lesson;
use App\Models\SubscriptionCode;
use Illuminate\Http\Request;

class SubjectAccessController extends Controller
{
    /**
     * التحقق من رمز الاشتراك وإعطاء الوصول للمادة
     */
    public function verify(Request $request, $gradeId, $subjectId)
    {
        $request->validate([
            'subscription_code' => 'required|string',
        ]);

        $subject = Subject::with('grade.stage')->findOrFail($subjectId);
        $grade   = Grade::findOrFail($gradeId);

        // البحث عن الرمز
        $code = SubscriptionCode::where('code', strtoupper(trim($request->subscription_code)))
            ->where('status', 'active')
            ->first();

        if (!$code) {
            return back()->withErrors(['subscription_code' => 'رمز الاشتراك غير صحيح أو منتهي الصلاحية.']);
        }

        // التحقق من صلاحية الرمز
        if (!$code->isValid()) {
            return back()->withErrors(['subscription_code' => 'رمز الاشتراك منتهي الصلاحية.']);
        }

        // التحقق أن الرمز مخصص لهذه المادة أو عام
        if ($code->subject_id && $code->subject_id !== (int) $subjectId) {
            return back()->withErrors(['subscription_code' => 'هذا الرمز غير مخصص لهذه المادة.']);
        }

        if ($code->grade_id && $code->grade_id !== (int) $gradeId) {
            return back()->withErrors(['subscription_code' => 'هذا الرمز غير مخصص لهذا الصف.']);
        }

        // تسجيل الاستخدام
        $code->update([
            'status'  => 'used',
            'used_by' => auth()->id(),
            'used_at' => now(),
        ]);

        // إذا كان المستخدم مسجل دخول، نقوم بتسجيله في كورسات هذه المادة
        if (auth()->check()) {
            $courses = \App\Models\Course::where('subject_id', $subjectId);
            if ($code->teacher_id) {
                $courses->where('teacher_id', $code->teacher_id);
            }
            $courseIds = $courses->pluck('id');
            if ($courseIds->isNotEmpty()) {
                auth()->user()->enrolledCourses()->syncWithoutDetaching($courseIds);
            }
        }

        // تخزين الوصول في الـ session
        $accessKey = "subject_access_{$subjectId}";
        session([$accessKey => true]);
        if ($code->teacher_id) {
            session(["subject_teacher_id_{$subjectId}" => $code->teacher_id]);
        }

        return redirect()->route('subject.videos', ['gradeId' => $gradeId, 'subjectId' => $subjectId])
            ->with('success', 'تم التحقق بنجاح! أهلاً بك في مادة ' . $subject->name);
    }

    /**
     * عرض فيديوهات المادة (بعد التحقق)
     */
    public function videos(Request $request, $gradeId, $subjectId)
    {
        $subject = Subject::with(['grade.stage'])->findOrFail($subjectId);

        // التحقق من الوصول (session أو اشتراك مسجل أو أدمن/مدرس)
        $accessKey = "subject_access_{$subjectId}";
        $hasEnrolled = auth()->check() && auth()->user()->enrolledCourses()->where('subject_id', $subjectId)->exists();
        if (!session($accessKey) && !auth()->user()?->isAdmin() && !auth()->user()?->isTeacher() && !$hasEnrolled) {
            return redirect()->route('grade.show', $gradeId)
                ->with('error', 'يجب إدخال رمز الاشتراك للوصول إلى هذه المادة.');
        }

        $teacherId = session("subject_teacher_id_{$subjectId}");
        $teacher = $teacherId ? \App\Models\User::find($teacherId) : null;

        // جلب الدروس من الكورسات المرتبطة بهذه المادة (وللمعلم إن كان الرمز مخصص لمعلم)
        $lessons = \App\Models\Lesson::whereHas('course', function ($q) use ($subjectId, $teacherId) {
            $q->where('subject_id', $subjectId);
            if ($teacherId) {
                $q->where('teacher_id', $teacherId);
            }
        })->with('course.teacher')->orderBy('order')->get();

        return view('xpro.subject_videos', compact('subject', 'lessons', 'gradeId', 'teacher'));
    }
}
