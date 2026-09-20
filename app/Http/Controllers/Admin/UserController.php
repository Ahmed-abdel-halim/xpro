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

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users,email',
            'phone'                 => 'nullable|string|max:30',
            'password'              => 'required|string|min:6',
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        User::create([
            'name'                  => $request->name,
            'email'                 => $request->email,
            'phone'                 => $request->phone,
            'password'              => \Illuminate\Support\Facades\Hash::make($request->password),
            'role'                  => 'teacher',
            'is_approved'           => $request->boolean('is_approved', true),
            'commission_percentage' => $request->filled('commission_percentage') ? floatval($request->commission_percentage) : 20.0,
        ]);

        return back()->with('success', 'تم إضافة المعلم بنجاح.');
    }

    public function updateTeacher(Request $request, User $user)
    {
        if ($user->role !== 'teacher') {
            return back()->with('error', 'هذا المستخدم ليس معلماً.');
        }

        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'                 => 'nullable|string|max:30',
            'password'              => 'nullable|string|min:6',
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $data = [
            'name'                  => $request->name,
            'email'                 => $request->email,
            'phone'                 => $request->phone,
            'commission_percentage' => $request->filled('commission_percentage') ? floatval($request->commission_percentage) : $user->commission_percentage,
            'is_approved'           => $request->boolean('is_approved'),
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'تم تحديث بيانات المعلم بنجاح.');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'phone'    => 'nullable|string|max:30',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'password'    => \Illuminate\Support\Facades\Hash::make($request->password),
            'role'        => 'student',
            'is_approved' => true,
        ]);

        return back()->with('success', 'تم إضافة الطالب بنجاح.');
    }

    public function updateStudent(Request $request, User $user)
    {
        if ($user->role !== 'student') {
            return back()->with('error', 'هذا المستخدم ليس طالباً.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:30',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'تم تحديث بيانات الطالب بنجاح.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
