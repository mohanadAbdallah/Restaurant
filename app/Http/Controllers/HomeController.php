<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {

        $restaurants = Restaurant::all();
        return view('home', compact('restaurants'));
    }

    public function showRestaurant(Restaurant $restaurant): View
    {
        $items = Item::where('restaurant_id',$restaurant->id)->get();
        $categories = Category::where('restaurant_id',$restaurant->id)->get();


        return view('home.restaurant.show', compact('restaurant','items','categories'));
    }

    public function showCategory(Category $category): View
    {

        $items = Item::where('category_id',$category->id)->get();

        return \view('home.restaurant.categories',compact('items'));
    }

}
