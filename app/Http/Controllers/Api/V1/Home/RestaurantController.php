<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Helpers\apiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;

class RestaurantController extends Controller
{

    public function index(): JsonResponse
    {
        return apiResponse::successResponse([
            'data' => RestaurantResource::collection(Restaurant::all()),

        ]);
    }

    public function show(Restaurant $restaurant): JsonResponse
    {
        $restaurant->load('categories.items');

        return apiResponse::successResponse(new RestaurantResource($restaurant), 200);
    }

}
