<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\SittingRequest;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $types = ['dog', 'cat', 'bird', 'fish', 'rodent', 'reptile'];
        $filterTypes = $request->input('types', ['all']);

        if (count($filterTypes) == 1 && in_array('all', $filterTypes)) {
            $pets = Pet::all();
        } else {
            $pets = Pet::whereIn('type', $filterTypes)->get();
        }

        return view('pets.index', [
            'types' => $types,
            'filterTypes' => $filterTypes,
            'pets' => $pets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:dog,cat,bird,fish,rodent,reptile',
            'age' => 'required|integer',
            'breed' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'hourly_rate' => 'required|numeric',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'image'=> 'required|image',
            'status' => 'required|string|in:available,not available',
        ]);

        if($request->has('image')){
            $file = $request->file('image')->store('public/pets');
            $validated['image'] = $file;
        }
 
        $request->user()->pets()->create($validated);
 
        return redirect(route('pets.index'));
    }

    /**
     * Display the specified resource.
     */

    public function show(Request $request, Pet $pet)
    {
        return app(SittingRequestController::class)->showPet($request, $pet);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet): View
    {
        Gate::authorize('update', $pet);
 
        return view('pets.edit', [
            'pet' => $pet,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet): RedirectResponse
    {
        Gate::authorize('update', $pet);
 
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:dog,cat,bird,fish,rodent,reptile',
            'age' => 'required|integer',
            'breed' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'hourly_rate' => 'required|numeric',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'image'=> 'nullable|image',
            'status' => 'required|string|in:available,not available',
        ]);

        //Check the current image of the pet
        $currentImage = $pet->image;

        if($request->has('image')){
            $file = $request->file('image')->store('public/pets');
            $validated['image'] = $file;

            //If there is a difference between the images remove the old one
            if ($currentImage && $currentImage !== $file){
                Storage::delete($currentImage);
            }
        }

        $pet->update($validated);
 
        return redirect(route('pets.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet): RedirectResponse
    {
        Gate::authorize('delete', $pet);

        //Delete the image from storage
        if($pet->image){
            Storage::delete($pet->image);
        }
 
        $pet->delete();
 
        return redirect(route('pets.index'));
    }
}
