<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SittingRequest;
use App\Models\Pet;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;


class SittingRequestController extends Controller
{

    public function showUser(user $user)
    {
        $showReviewBox = false;
        $sittingRequests = SittingRequest::where('user_id', $user->id)->get();
        
        foreach ($sittingRequests as $request) {
            if ($request->user_id == $user->id && $request->pet_owner_id == auth()->id() && $request->status == 'accepted') {
                $showReviewBox = true;
                break;
            }
        }

        $reviews = Review::where('sitter_id', $user->id)->get();

        return view('profile.show', [
            'user' => $user,
            'sittingRequests' => $sittingRequests,
            'showReviewBox' => $showReviewBox,
            'reviews' => $reviews,
        ]);
    }

    public function showDashboard(Request $request){
        //Show the requests of sitter
        $sittingRequests = $request->user()->sittingRequests()->get();

        //Show the requests to owner of pet
        $petOwnerSittingRequests = SittingRequest::where('pet_owner_id', $request->user()->id)->get();

        $user = Auth::user();
        $allSittingRequests = SittingRequest::all();

        return view('/dashboard', [
            'sittingRequests' => $sittingRequests,
            'petOwnerSittingRequests' => $petOwnerSittingRequests,
            'allSittingRequests' => $allSittingRequests,
        ]);
    }

    public function showPet(Request $request, Pet $pet){
        $lastRequest = $request->user()->sittingRequests()->where('pet_id', $pet->id)->get()->last();

        return view('pets.show', [
            'pet' => $pet,
            'lastRequest' => $lastRequest,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pet_id' => 'required|exists:pets,id',
            'pet_owner_id' => 'required|exists:users,id',
            'status' => 'required|string|in:pending,accepted,rejected',
        ]);

        $request->user()->sittingRequests()->create($validated);

        return redirect(route('pets.show', ['pet' => $validated['pet_id']]));
    }

    public function accept($id)
    {
        $sittingRequest = SittingRequest::find($id);
        $sittingRequest->status = 'accepted';
        $sittingRequest->save();

        $pet = Pet::find($sittingRequest->pet_id);
        $pet->status = 'not available';
        $pet->save();

        return redirect()->back();
    }

    public function decline($id)
    {
        $sittingRequest = SittingRequest::find($id);
        $sittingRequest->status = 'rejected';
        $sittingRequest->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        if (Auth::user()->role == 1) {
            $sittingRequest = SittingRequest::find($id);
            $sittingRequest->delete();
        }
        
        return redirect()->back();
    }
}
