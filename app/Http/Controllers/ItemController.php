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

    public function index(): View
    {
        $this->authorize('viewAny', \auth()->user());

        $items = Item::where('restaurant_id',auth()->user()->restaurant->id)->get();
        return view('item.index', compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', \auth()->user());

        $categories = auth()->user()->restaurant->categories;
        return view('item.create', compact('categories'));
    }

    public function store(ItemRequest $request): RedirectResponse
    {
        $this->authorize('create', \auth()->user());
        $validatedData = $request->validated();
        $validatedData['category_id'] = $request->category_id;

        $validatedData['restaurant_id'] = auth()->user()->restaurant->id;

        if ($request->hasFile('image')) {

            $imageName = $request->image->getClientOriginalName();
            $request->file('image')->store('images', 'public');

            $validatedData['image'] = $imageName;
        }

        $item =Item::create($validatedData);
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
        $this->authorize('update', \auth()->user());

        $categories = auth()->user()->restaurant->categories->whereNotNull('parent_id');
        return view('item.edit', compact('item','categories'));
    }

    public function update(ItemRequest $request, Item $item): RedirectResponse
    {
        $this->authorize('update', \auth()->user());
        $old_image = $item->image;

        $validatedDate = $request->validated();
        if ($request->hasFile('image')){
            $image_name = $request->input('image')->getClientOriginalName();

            $request->file('image')->store('images', 'public');
            $item->image = $image_name;
        }

        $item->update($validatedDate);
        if ($old_image && $validatedDate['image']){
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('items.index')->with('status','تم التحديث بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item): RedirectResponse
    {
        $this->authorize('delete', \auth()->user());

        $item->delete();
        return redirect()->back()->with('status', 'تم الحذف بنجاح');
    }
}
