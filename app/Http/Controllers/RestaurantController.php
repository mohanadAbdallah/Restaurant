<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Restaurant::class, 'restaurant');
    }

    public function index(): View
    {
        $restaurants = Restaurant::all();

        return view('restaurant.index', compact('restaurants'));
    }

    public function create(): View
    {
        $users = User::where('type', 1)
            ->WhereDoesntHave('restaurant')
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'Super Admin');
            })->get();

        return view('restaurant.create', compact('users'));
    }

    public function store(RestaurantRequest $request): RedirectResponse
    {
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
        return view('restaurant.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant): View
    {
        return view('restaurant.edit', compact('restaurant'));
    }

    public function update(RestaurantRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $imageName = $request->image->getClientOriginalName();

            $request->file('image')->storeAs('images', $imageName,'public');
            $validatedData['image'] = $imageName;
        }

        $restaurant->update($validatedData);

        return auth()->user()->hasRole('Super Admin')
            ? redirect()->route('restaurant.index')->with('status', 'تم التحديث بنجاح')
            : redirect()->back()->with('status', 'تم تحديث المطعم بنجاح');
    }

    public function destroy(Restaurant $restaurant): RedirectResponse
    {
        $restaurant->delete();
        return redirect()->route('restaurant.index')->with('status', 'تمت عملية الحذف بنجاح.');
    }
}
