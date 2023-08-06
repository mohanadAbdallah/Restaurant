<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\ApiController;
use App\Http\Resources\RestaurantResource;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class RestaurantController extends ApiController
{

    public function index(): JsonResponse
    {
        return $this->successResponse(RestaurantResource::collection(Restaurant::all()), 200);

    }

    public function show(Restaurant $restaurant): JsonResponse
    {
        $restaurant->load('categories.items');

        return $this->successResponse([
            'restaurant'=> new RestaurantResource($restaurant),
        ],200);
    }

}
