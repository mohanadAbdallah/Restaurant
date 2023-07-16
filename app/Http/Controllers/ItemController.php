<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Category;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ItemController extends Controller
{

    public function index(): View
    {
        $user = auth()->user();

        $items = Item::with('categories')
            ->whereHas('categories', function ($query) use ($user) {
                $query->whereHas('restaurant', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            })
            ->get();
        return view('item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = auth()->user()->restaurant->categories->whereNotNull('parent_id');

        return view('item.create', compact('categories'));
    }

    public function store(ItemRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['category_id'] = $request->category_id;

        if ($request->hasFile('image') && $request->image != null) {
            $imageName = $request->image->getClientOriginalName();
            $request->image->storeAs('public/images', $imageName);

            $validatedData['image'] = $imageName;
        }

        $item =Item::create($validatedData);
        $category = Category::findOrFail($request->category_id);

        $item->categories()->attach($category, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        return redirect()->route('items.index')->with('status', 'Item Created Successfully');
    }

    public function show(Item $item): View
    {
        return \view('item.show', compact('item'));
    }

    public function edit(Item $item): View
    {
        return view('item.edit', compact('item'));
    }

    public function update(ItemRequest $request, Item $item): RedirectResponse
    {
        $validatedDate = $request->validated();

        $item->update($validatedDate);
        return redirect()->route('items.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();
        return redirect()->back()->with('status', 'Item Deleted Successfully');
    }
}
