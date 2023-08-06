<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class RestaurantController extends ApiController
{

    public function index(): JsonResponse
    {
        $restaurants= Restaurant::all();
        return $this->showAll($restaurants);

    }

    public function show(Restaurant $restaurant): JsonResponse
    {
        $items = Item::where('restaurant_id',$restaurant->id)->get();
        $categories = Category::where('restaurant_id',$restaurant->id)->get();

        $data = [
            'restaurant' => $restaurant,
            'items' => $items,
            'categories' => $categories,
        ];

        return $this->showAll(new Collection($data));
    }

}
