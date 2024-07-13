<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Review;

class ReviewController extends Controller
{

    public function show(User $user)
    {
        $reviews = Review::where('user_id', $user->id)->get();

        return view('profile.show', [
            'user' => $user,
            'reviews' => $reviews
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sitter_id' => 'required|exists:users,id',
            'pet_owner_id' => 'required|exists:users,id',
            'review' => 'required|string|max:255',
        ]);

        $request->user()->reviews()->create($validated);

        return back();
    }
}
