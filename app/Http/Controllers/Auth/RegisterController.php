<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(UpdateUserRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($request->password);
        $validatedData['type'] = 0;

        $user = User::create($validatedData);
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
