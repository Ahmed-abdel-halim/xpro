<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show($id)
    {
        $course = Course::with('lessons', 'teacher')->findOrFail($id);
        $isEnrolled = false;
        $hasPending = false;
        
        if (auth()->check()) {
            $isEnrolled = Enrollment::where('student_id', auth()->id())
                ->where('course_id', $id)
                ->exists();

            if (!$isEnrolled) {
                $hasPending = \App\Models\Payment::where('student_id', auth()->id())
                    ->where('course_id', $id)
                    ->where('status', 'pending')
                    ->exists();
            }
        }

        return view('courses.show', compact('course', 'isEnrolled', 'hasPending'));
    }

    public function enroll($id)
    {
        $course = Course::findOrFail($id);
        
        // Mocking payment success for now
        Enrollment::updateOrCreate([
            'student_id' => auth()->id(),
            'course_id' => $id,
        ]);

        return redirect()->back()->with('success', 'تم الاشتراك في الكورس بنجاح!');
    }
}
