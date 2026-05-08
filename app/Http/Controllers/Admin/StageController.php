<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
{
    public function index()
    {
        $stages = Stage::withCount('grades')->get();
        return view('admin.stages.index', compact('stages'));
    }

    public function create()
    {
        return view('admin.stages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $directory = public_path('images/stages');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move($directory, $imageName);
            $data['image'] = '/images/stages/'.$imageName;
        }

        Stage::create($data);

        return redirect()->route('admin.stages.index')->with('success', 'تم إضافة المرحلة بنجاح');
    }

    public function edit(Stage $stage)
    {
        return view('admin.stages.edit', compact('stage'));
    }

    public function update(Request $request, Stage $stage)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $directory = public_path('images/stages');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Optional: delete old image if exists
            if ($stage->image && file_exists(public_path($stage->image))) {
                @unlink(public_path($stage->image));
            }

            $imageName = time().'.'.$request->image->extension();  
            $request->image->move($directory, $imageName);
            $data['image'] = '/images/stages/'.$imageName;
        }

        $stage->update($data);

        return redirect()->route('admin.stages.index')->with('success', 'تم تحديث المرحلة بنجاح');
    }

    public function destroy(Stage $stage)
    {
        $stage->delete();
        return redirect()->route('admin.stages.index')->with('success', 'تم حذف المرحلة بنجاح');
    }
}
