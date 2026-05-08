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
        
        // Group available courses by teacher
        $teachers = \App\Models\User::whereHas('courses', function($query) use ($id) {
            $query->where('subject_id', $id);
        })->withCount(['courses' => function($query) use ($id) {
            $query->where('subject_id', $id);
        }])->get();

        return view('xpro.subject', compact('subject', 'teachers'));
    }

    public function teacherCourses($subjectId, $teacherId)
    {
        $subject = Subject::findOrFail($subjectId);
        $teacher = \App\Models\User::findOrFail($teacherId);
        $courses = $subject->courses()->where('teacher_id', $teacherId)->get();

        return view('xpro.teacher_courses', compact('subject', 'teacher', 'courses'));
    }
}
