<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    /**
     * عرض قائمة الاختصاصات
     */
    public function index()
    {
        $specializations = Specialization::withCount('teachers')->latest()->get();
        return view('admin.specializations.index', compact('specializations'));
    }

    /**
     * حفظ اختصاص جديد بواسطة الأدمن
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:specializations,name',
        ], [
            'name.required' => 'يرجى كتابة اسم الاختصاص.',
            'name.unique'   => 'هذا الاختصاص موجود بالفعل في القائمة.',
        ]);

        Specialization::create([
            'name' => trim($request->name),
        ]);

        return back()->with('success', 'تم إضافة الاختصاص الجديد بنجاح، وأصبح متاحاً للأساتذة للاختيار منه.');
    }

    /**
     * تعديل اسم اختصاص
     */
    public function update(Request $request, Specialization $specialization)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:specializations,name,' . $specialization->id,
        ], [
            'name.required' => 'يرجى كتابة اسم الاختصاص.',
            'name.unique'   => 'هذا الاختصاص مسجل مسبقاً.',
        ]);

        $oldName = $specialization->name;
        $newName = trim($request->name);

        if ($oldName !== $newName) {
            // تحديث اسم الاختصاص لدى الأساتذة المسجلين به
            User::where('specialization', $oldName)->update(['specialization' => $newName]);
            $specialization->update(['name' => $newName]);
        }

        return back()->with('success', 'تم تعديل اسم الاختصاص بنجاح.');
    }

    /**
     * حذف اختصاص بواسطة الأدمن
     */
    public function destroy(Specialization $specialization)
    {
        $name = $specialization->name;
        $specialization->delete();

        return back()->with('success', 'تم حذف اختصاص (' . $name . ') بنجاح من المنصة.');
    }
}
