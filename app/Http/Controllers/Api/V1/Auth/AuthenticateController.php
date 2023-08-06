<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthenticateController extends Controller
{
    use ApiResponser;

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        if (is_null($user) || !Auth::getProvider()->validateCredentials($user, $credentials)) {
            throw new \Exception('invalid');
        }
        $token = $user->createToken('Registration token')->plainTextToken;

        return $this->successResponse(['user' => $user, 'token' => $token], 200);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $this->successResponse('User Logged Out', 200);
    }

    public function profile(): JsonResponse
    {
        $user = Auth::user();

        return $this->successResponse($user, 200);
    }

    public function update_profile(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . \auth()->id()],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'image' => ['nullable', 'file'],
        ]);
        $user = auth()->user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('image') && $request->image != null) {
            $imageName = $request->image->getClientOriginalName();
            $request->image->storeAs('public/images', $imageName);
            $user->image = $imageName;
        }

        $user->save();

        return $this->successResponse($user, 200);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT

            ? $this->successResponse('Email sent, please check your inbox and click Reset Password.', 200)
            : $this->errorResponse('Password reset link could not be sent.', 400);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return $this->successResponse('Password reset successfully.', 200);
        } else {
            return $this->errorResponse('Password reset could not be completed.', 400);
        }
    }
}
