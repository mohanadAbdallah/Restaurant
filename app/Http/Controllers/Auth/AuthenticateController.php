<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthenticateController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            $auth_user = auth()->user()->getRoleNames()->toArray();


            return in_array('Super Admin',$auth_user)
            ? redirect()->intended('dashboard')
            : redirect()->intended('');
        }
        return back()
            ->withErrors(['email' => 'These credentials dont match our records'])
            ->onlyInput('email');
    }

    public function profile(): View
    {
        $user = Auth::user();
        return view('auth.user.profile', compact('user'));
    }
    public function update_profile(UpdateUserProfileRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('image') && $request->image != null){
            $imageName = $request->image->getClientOriginalName();
            $request->image->storeAs('public/images', $imageName);
            $user->image = $imageName;
        }

        $user->save();

        return redirect()->back()->with('status','Updated Successfully');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function forgotPassword (Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect()->route('reset.wait')->with(['status' => 'email sent pleas check your inbox and click Reset Password.'])
            : back()->withErrors(['email' => __($status)]);
    }

    public function wait(): View
    {
        return \view('auth.wait');
    }
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('user.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);

    }
}
