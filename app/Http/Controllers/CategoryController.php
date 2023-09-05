<?php

namespace App\Http\Controllers;

use App\Events\NewMessageNotification;
use App\Models\Category;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    public function index(): View
    {
        $user_id = auth()->user()->id;
        $restaurant = auth()->user()->restaurant;

        $categories = null;

        if ($restaurant){
            $categories = $restaurant->categories()->get();
        }

        return view('category.index', compact('categories','user_id'));
    }

    public function create(): View
    {
        $categories = null;

        $restaurant = auth()->user()->restaurant;

        if ($restaurant){
            $categories = $restaurant->categories()->whereNull('parent_id')->get();
        }

        return view('category.create', compact('categories'));
    }

    public function store(Request $request, $parent_id =null): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'unique:categories'],
        ]);


        $validatedData['slug'] = Str::slug($validatedData['title']);
        $validatedData['restaurant_id'] = auth()->user()->restaurant->id;

        if ($request->hasFile('image')) {

            $imageName = $request->image->getClientOriginalName();
            $request->file('image')->storeAs('images',$imageName,'public');

            $validatedData['image'] = $imageName;

        }

        if ($request->filled('parent_id')) {
            $validatedData['parent_id'] = $request->input('parent_id');

        }

        if ($parent_id){
            $validatedData['parent_id'] = $parent_id;
        }

        Category::create($validatedData);

        return redirect()->route('categories.index')->with('status', 'Successfully Created Category.');
    }

    public function show(Category $category): View
    {
        $category->load('subCategories', 'items')->get();
        return view('category.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string']
        ]);

        if ($request->hasFile('image') && $request->image != null) {
            $imageName = $request->image->getClientOriginalName();
            $request->file('image')->storeAs('images',$imageName,'public');

            $validatedData['image'] = $imageName;
        }

        $category->update($validatedData);
        return redirect()->route('categories.index')->with('status', 'Category Updated Successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

       return redirect()->route('categories.index')->with('status', 'Category Deleted Successfully.');
    }
}
