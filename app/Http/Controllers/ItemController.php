<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Category;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ItemController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Item::class, 'item');
    }

    public function index(): View
    {
        $items = Item::where('restaurant_id', auth()->user()->restaurant->id)->get();
        return view('item.index', compact('items'));

    }

    public function create(): View
    {
        $categories = auth()->user()->restaurant->categories;
        return view('item.create', compact('categories'));
    }

    public function store(ItemRequest $request): RedirectResponse
    {

        $validatedData = $request->validated();
        $validatedData['category_id'] = $request->category_id;

        $validatedData['restaurant_id'] = auth()->user()->restaurant->id;

        if ($request->hasFile('image')) {

            $imageName = $request->image->getClientOriginalName();
            $request->file('image')->storeAs('images', $imageName, 'public');

            $validatedData['image'] = $imageName;
        }

        $item = Item::create($validatedData);
        $category = Category::findOrFail($request->category_id);

        $item->categories()->attach($category, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        return redirect()->route('items.index')->with('status', 'تمت إضافة عنصر بنجاح');
    }

    public function show(Item $item): View
    {
        return \view('item.show', compact('item'));
    }

    public function edit(Item $item): View
    {
        $categories = auth()->user()->restaurant->categories;
        return view('item.edit', compact('item', 'categories'));
    }

    public function update(ItemRequest $request, Item $item): RedirectResponse
    {
        $validatedDate = $request->validated();

        if ($request->hasFile('image')) {

            $image_name = $request->image->getClientOriginalName();
            $request->file('image')->storeAs('images', $image_name, 'public');
            $item->image = $image_name;
            $validatedDate['image'] = $image_name;
        }

        $item->update($validatedDate);

        return redirect()->route('items.index')->with('status', 'تم التحديث بنجاح');
    }

    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        return redirect()->back()->with('status', 'تم الحذف بنجاح');
    }
}
