<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Stage;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::with('grade.stage')->withCount('courses');
        
        if ($request->has('grade_id') && $request->grade_id != '') {
            $query->where('grade_id', $request->grade_id);
        }

        if ($request->has('stage_id') && $request->stage_id != '') {
            $query->whereHas('grade', function($q) use ($request) {
                $q->where('stage_id', $request->stage_id);
            });
        }

        
        $subjects = $query->get();
        $stages = Stage::with('grades')->get();
        
        return view('admin.subjects.index', compact('subjects', 'stages'));
    }

    public function create()
    {
        $stages = Stage::with('grades')->get();
        return view('admin.subjects.create', compact('stages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $directory = public_path('images/subjects');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move($directory, $imageName);
            $data['image'] = '/images/subjects/'.$imageName;
        }

        Subject::create($data);

        return redirect()->route('admin.subjects.index')->with('success', 'تم إضافة المادة بنجاح');
    }

    public function edit(Subject $subject)
    {
        $stages = Stage::with('grades')->get();
        return view('admin.subjects.edit', compact('subject', 'stages'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $directory = public_path('images/subjects');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move($directory, $imageName);
            $data['image'] = '/images/subjects/'.$imageName;
        }

        $subject->update($data);

        return redirect()->route('admin.subjects.index')->with('success', 'تم تحديث المادة بنجاح');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('admin.subjects.index')->with('success', 'تم حذف المادة بنجاح');
    }

    public function courses(Subject $subject)
    {
        $courses = $subject->courses()->with('teacher')->withCount('lessons', 'enrollments')->get();
        return view('admin.subjects.courses', compact('subject', 'courses'));
    }
}
