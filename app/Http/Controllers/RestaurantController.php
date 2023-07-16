<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    public function index(): View
    {

        $restaurants = Restaurant::all();

        return view('restaurant.index', compact('restaurants'));
    }

    public function create(): View
    {
        $users =User::where('type',1)->get();
        return view('restaurant.create',compact('users'));
    }

    public function store(RestaurantRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if (request()->hasFile('image') && $request->image != null) {
            $imageName = $request->image->getClientOriginalName();
            $request->image->storeAs('public/images', $imageName);
            $validatedData['image'] = $imageName;
        }

        Restaurant::create($validatedData);
        return redirect()->route('restaurant.index');
    }

    public function show(Restaurant $restaurant): View
    {
        $this->authorize('view', $restaurant);
        return view('restaurant.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant): View
    {
        return view('restaurant.edit', compact('restaurant'));
    }

    public function update(RestaurantRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image') && $request->image != null) {
            $imageName = $request->image->getClientOriginalName();
            $request->image->storeAs('public/images', $imageName);
            $validatedData['image'] = $imageName;
        }
        $restaurant->update($validatedData);
        return  auth()->user()->hasRole('Super Admin')
            ? redirect()->route('restaurant.index')
            : redirect()->back()->with('status','Restaurant data Successfully updated');
    }

    public function destroy(Restaurant $restaurant): RedirectResponse
    {
        $image_path = public_path("storage/images/" . $restaurant->image);

        if (file_exists($image_path)) {
            unlink($image_path);
        }

        $restaurant->delete();
        return redirect()->route('restaurant.index')->with('status', 'Deleted Successfully.');
    }
}
