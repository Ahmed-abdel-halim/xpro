<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function teachers()
    {
        $teachers = User::where('role', 'teacher')->latest()->get();
        return view('admin.users.teachers', compact('teachers'));
    }

    public function students()
    {
        $students = User::where('role', 'student')->latest()->get();
        return view('admin.users.students', compact('students'));
    }

    public function approveTeacher(User $user)
    {
        if ($user->role !== 'teacher') {
            return back()->with('error', 'هذا المستخدم ليس معلماً');
        }

        $user->update(['is_approved' => true]);
        return back()->with('success', 'تم اعتماد المعلم بنجاح.');
    }

    public function updateTeacherSettings(Request $request, User $user)
    {
        if ($user->role !== 'teacher') {
            return back()->with('error', 'هذا المستخدم ليس معلماً');
        }

        $user->update([
            'commission_percentage' => floatval($request->commission_percentage),
        ]);

        return back()->with('success', 'تم تحديث نسبة العمولة بنجاح.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
