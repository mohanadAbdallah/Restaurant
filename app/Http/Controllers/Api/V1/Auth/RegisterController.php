<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class RegisterController extends ApiController
{
    public function store(StoreUserRequest $request) :JsonResponse
    {
        $user = User::create($request->validated());
        event(new Registered($user));

        $token = $user->createToken('Registration token')->plainTextToken;
        $data = [
            'user' => $user,
            'token' => $token,
            ];
        return $this->showAll(new Collection($data));

    }
}
