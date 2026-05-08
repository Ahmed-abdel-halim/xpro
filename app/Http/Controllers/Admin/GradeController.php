<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Stage;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::with('stage')->withCount('subjects');
        
        if ($request->has('stage_id')) {
            $query->where('stage_id', $request->stage_id);
        }
        
        $grades = $query->get();
        $stages = Stage::all();
        
        return view('admin.grades.index', compact('grades', 'stages'));
    }

    public function create()
    {
        $stages = Stage::all();
        return view('admin.grades.create', compact('stages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'name' => 'required|string|max:255',
        ]);

        Grade::create($request->all());

        return redirect()->route('admin.grades.index')->with('success', 'تم إضافة الصف بنجاح');
    }

    public function edit(Grade $grade)
    {
        $stages = Stage::all();
        return view('admin.grades.edit', compact('grade', 'stages'));
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'name' => 'required|string|max:255',
        ]);

        $grade->update($request->all());

        return redirect()->route('admin.grades.index')->with('success', 'تم تحديث الصف بنجاح');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('admin.grades.index')->with('success', 'تم حذف الصف بنجاح');
    }
}
