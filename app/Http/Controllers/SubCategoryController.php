<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $parent_id): RedirectResponse
    {
        $validatedData = $request->validate([
            'title'=>['required'],
        ]);
        $validatedData['parent_id'] = $parent_id;
        $validatedData['restaurant_id'] = auth()->user()->restaurant->id ?? [];
        $validatedData['slug'] = auth()->user()->restaurant->id ?? [];

        $category =Category::findOrFail($parent_id);
        $subcategory = Category::create($validatedData);
        $category->subcategories()->save($subcategory);

        return redirect()->route('categories.show',$parent_id)->with(['status' => 'Subcategory created successfully']);


    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }
}
