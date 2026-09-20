<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $subjects = Subject::select('name')->distinct()->orderBy('name')->pluck('name');
        return view('auth.register', compact('subjects'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:25'],
            'role' => ['required', 'string', 'in:student,teacher'],
            'specialization' => ['required_if:role,teacher', 'nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ], [
            'specialization.required_if' => 'يرجى تحديد اختصاص الأستاذ (المادة الدراسية).',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'specialization' => $request->role === 'teacher' ? $request->specialization : null,
            'avatar' => $avatarPath,
            'is_approved' => true, // متاح للأستاذ رفع محاضراته مباشرة بعد التسجيل
            'password' => Hash::make($request->password),
        ]);

        // إذا كان أستاذ، نربط له كورس تلقائي في مادته لتسهيل رفع المحاضرات فوراً
        if ($user->isTeacher() && $request->filled('specialization')) {
            $matchedSubject = Subject::where('name', $request->specialization)
                ->orWhere('name', 'like', '%' . $request->specialization . '%')
                ->first();

            if ($matchedSubject) {
                Course::firstOrCreate(
                    [
                        'teacher_id' => $user->id,
                        'subject_id' => $matchedSubject->id,
                    ],
                    [
                        'title' => 'شرح مادة ' . $matchedSubject->name . ' - الأستاذ ' . $user->name,
                        'description' => 'كافة المحاضرات والشروحات لمادة ' . $matchedSubject->name . ' مع الأستاذ ' . $user->name,
                        'price' => 0,
                    ]
                );
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
