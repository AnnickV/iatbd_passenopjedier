<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function show(User $user) {
        $reviews = Review::where('sitter_id', $user->id)->get();

        return view('profile.show', [
            'user' => $user,
            'reviews' => $reviews
        ]);
    }


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
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        //Check if there is an avatar
        if ($request->hasFile('avatar')) {
            $currentAvatar = $request->user()->avatar;

            //Save avatar in public/avatars
            $file = $request->file('avatar')->store('public/avatars');
            $request->user()->avatar = $file;

            //If there is a difference between the avatar and the new one, delete the old avatar
            if ($currentAvatar && $currentAvatar !== $file) {
                Storage::delete($currentAvatar);
            }
        } elseif($request->input('reset_avatar')){
            if ($request->user()->avatar && $request->user()->avatar != 'img/default_avatar.png') {
                Storage::delete($request->user()->avatar);
            }
            $request->user()->avatar = 'img/default_avatar.png';
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

    Public function block(User $user): RedirectResponse
    {
        $user->blocked = 1;
        $user->save();

        return redirect()->back();
    }

    Public function unblock(User $user): RedirectResponse
    {
        $user->blocked = 0;
        $user->save();
        
        return redirect()->back();
    }
}