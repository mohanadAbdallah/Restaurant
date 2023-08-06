<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', \auth()->user());

        $restaurants = Restaurant::all();
        return view('restaurant.index', compact('restaurants'));
    }

    public function create(): View
    {
        $this->authorize('create', \auth()->user());

        $users = User::where('type', 1)
            ->WhereDoesntHave('restaurant')
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'Super Admin');
            })->get();

        return view('restaurant.create', compact('users'));
    }

    public function store(RestaurantRequest $request): RedirectResponse
    {
        $this->authorize('create', \auth()->user());

        $validatedData = $request->validated();

        if (request()->hasFile('image')) {
            $imageName = $request->image->getClientOriginalName();

            $request->image->store('images','public');
            $validatedData['image'] = $imageName;
        }


        $restaurant= Restaurant::create($validatedData);

        $user = User::findOrFail($request->input('user_id'));

        $user->update([
            'restaurant_id' => $restaurant->id
        ]);

        return redirect()->route('restaurant.index')->with('status','تمت عملية إضافة مطعم بنجاح');
    }

    public function show(Restaurant $restaurant): View
    {
        $this->authorize('view', $restaurant);
        return view('restaurant.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant): View
    {
        $this->authorize('update', [$restaurant, \auth()->user()]);

        return view('restaurant.edit', compact('restaurant'));
    }

    public function update(RestaurantRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $this->authorize('update', [$restaurant, \auth()->user()]);

        $validatedData = $request->validated();
        $old_image = $restaurant->image;

        if ($request->hasFile('image')) {
            $imageName = $request->image->getClientOriginalName();

            $request->file('image')->store('images','public');
            $validatedData['image'] = $imageName;
        }
        $restaurant->update($validatedData);
        if ($old_image && isset($validatedData['image'])){
            Storage::disk('public')->delete($old_image);
        }


        return auth()->user()->hasRole('Super Admin')
            ? redirect()->route('restaurant.index')->with('status', 'تم التحديث بنجاح')
            : redirect()->back()->with('status', 'تم تحديث المطعم بنجاح');
    }

    public function destroy(Restaurant $restaurant): RedirectResponse
    {
        $this->authorize('delete', \auth()->user());

        $restaurant->delete();
        return redirect()->route('restaurant.index')->with('status', 'تمت عملية الحذف بنجاح.');
    }
}
