<?php

namespace App\Http\Controllers;

use App\Events\NewMessageNotification;
use App\Models\Category;
use App\Models\Item;
use App\Models\Message;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function sendMessage(Request $request , $id)
    {

        $fromUser = Auth::user()->id;
        $restaurant = Restaurant::findOrFail($id)->first();

        $toUser = $restaurant->user_id;

        $message = new Message;
        $message->setAttribute('from', $fromUser);
        $message->setAttribute('to', $toUser);

        $message->setAttribute('message',$request->input('message'));
        $message->save();

        // want to broadcast NewMessageNotification event
        event(new NewMessageNotification($message));
    }

    public function respondToMessage()
    {

    }


    public function showCategory(Category $category): View
    {

        $items = Item::where('category_id',$category->id)
            ->where('restaurant_id',$category->restaurant_id)->get();

        return \view('home.restaurant.categories',compact('items'));
    }

}
