<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = auth()->user()->courses()->with('subject.grade.stage')->latest()->get();
        return view('teacher.courses.index', compact('courses'));
    }

    public function create()
    {
        $stages = Stage::with('grades.subjects')->get();
        return view('teacher.courses.create', compact('stages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('thumbnail');
        $data['teacher_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $data['thumbnail'] = Storage::url($path);
        }

        Course::create($data);

        return redirect()->route('teacher.courses.index')->with('success', 'تم إنشاء الكورس بنجاح.');
    }

    public function edit(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }
        $stages = Stage::with('grades.subjects')->get();
        return view('teacher.courses.edit', compact('course', 'stages'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('thumbnail');

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($course->thumbnail) {
                $oldPath = str_replace('/storage/', '', $course->thumbnail);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $data['thumbnail'] = Storage::url($path);
        }

        $course->update($data);

        return redirect()->route('teacher.courses.index')->with('success', 'تم تحديث الكورس بنجاح.');
    }

    public function destroy(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        if ($course->thumbnail) {
            $oldPath = str_replace('/storage/', '', $course->thumbnail);
            Storage::disk('public')->delete($oldPath);
        }

        $course->delete();

        return redirect()->route('teacher.courses.index')->with('success', 'تم حذف الكورس بنجاح.');
    }
}
