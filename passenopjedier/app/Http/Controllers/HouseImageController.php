<?php

namespace App\Http\Controllers;

use App\Models\HouseImage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class HouseImageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image',
        ]);

        if($request->has('image')){
            $file = $request->file('image')->store('public/house_images');
        }
 
        $houseImage = $request->user()->houseImages()->create([
            'image' => $file,
        ]);

        return redirect()->route('profile.show', ['user' => Auth::user()->id]);
    }

    public function destroy(HouseImage $houseImage): RedirectResponse
    {
        Gate::authorize('delete', $houseImage);

        if($houseImage->image){
            Storage::delete($houseImage->image);
        }
 
        $houseImage->delete();
 
        return redirect(route('profile.show', ['user' => Auth::user()->id]));
    }
}
