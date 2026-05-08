<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Handle payout details update (can be partial from teacher earnings page)
        if ($request->has('payout_method') || $request->has('payout_details')) {
            $user->fill($request->only(['payout_method', 'payout_details']));
        }

        // Handle main profile update
        if ($request->has('name') || $request->has('email')) {
             $data = $request->validate([
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'email' => ['sometimes', 'required', 'string', 'lowercase', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
                'phone' => ['sometimes', 'required', 'string', 'max:20'],
            ]);
            $user->fill($data);
        }

        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
