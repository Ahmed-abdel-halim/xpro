<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $stages = Stage::all();
        $faqs = \App\Models\Faq::where('is_active', true)->orderBy('sort_order')->get();
        return view('xpro.index', compact('stages', 'faqs'));
    }

    public function stage($id)
    {
        $stage = Stage::findOrFail($id);
        $grades = $stage->grades;
        return view('xpro.stage', compact('stage', 'grades'));
    }

    public function grade($id)
    {
        $grade = Grade::findOrFail($id);
        $subjects = $grade->subjects;
        return view('xpro.grade', compact('grade', 'subjects'));
    }

    public function subject($id)
    {
        $subject = Subject::findOrFail($id);
        $hasAccess = session("subject_access_{$id}") 
            || (auth()->check() && (
                auth()->user()->isAdmin() 
                || auth()->user()->isTeacher() 
                || auth()->user()->enrolledCourses()->where('subject_id', $id)->exists()
            ));

        if ($hasAccess) {
            return redirect()->route('subject.videos', ['gradeId' => $subject->grade_id, 'subjectId' => $subject->id]);
        }

        return redirect()->route('grade.show', $subject->grade_id)->with('info', 'يرجى إدخال رمز الاشتراك للوصول لمادة ' . $subject->name);
    }

    public function teacherCourses($subjectId, $teacherId)
    {
        $subject = Subject::findOrFail($subjectId);
        $teacher = \App\Models\User::findOrFail($teacherId);
        $courses = $subject->courses()->where('teacher_id', $teacherId)->get();

        return view('xpro.teacher_courses', compact('subject', 'teacher', 'courses'));
    }
}
