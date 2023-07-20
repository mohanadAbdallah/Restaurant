<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\registeredUserEmail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index(): View
    {
        $this->authorize('viewAny', \auth()->user());

        $users = User::query();

        $userRole = auth()->user()->getRoleNames();

        if ($userRole->contains('Super Admin')) {
            $users = $users->whereHas("roles", function ($q) {
                $q->whereIn('name', ['Admin', 'Data Entry', 'Financial']);
            })->get();
        }
        if (auth()->user()->restaurant) {
            $users = $users->where('restaurant_id', auth()->user()->restaurant->id)->with('roles')->get();
        }

        return view('auth.user.index', compact('users'));
    }

    public function create(): View
    {
        $this->authorize('create', \auth()->user());

        $roles = Role::where('name', '!=', 'Super Admin')->get();

        return \view('auth.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', \auth()->user());

        $validatedData = $request->validated();

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            $password = Str::random('9');
            $validatedData['password'] = Hash::make($password);
        }

        $dataEntryRole = Role::query()->where('name', '=', 'Data Entry')->first('id');

        $userRole = auth()->user()->getRoleNames();

        if (auth()->user()->restaurant) {
            $validatedData['restaurant_id'] = auth()->user()->restaurant->id;
        }
        $validatedData['type'] = 1;

        if ($request->hasFile('image')) {
            $imageName = $request->image->getClientOriginalName();
            $request->file('image')->storeAs('images', $imageName, 'public');
            $validatedData['image'] = $imageName;
        }

        $user = User::create($validatedData);

        $roles = $userRole->contains('super admin', $userRole)
            ? Role::where('name', 'Admin')->first('id')
            : $request->input('roles');

        $user->syncRoles($roles);

        $userPassword = $request->password;

        Mail::to($user->email)->send(new registeredUserEmail($userPassword,$validatedData));

        return $request->ajax()
            ? response()->json(
                [
                    'status' => 'success',
                    'data' => $user,
                    'message' => 'Information saved successfully!'
                ], 200)
            : redirect()->route('users.index')->with('status', 'User Created Successfully.');
    }

    public function show(User $user): View
    {
        return \view('auth.user.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $this->authorize('update', [$user, \auth()->user()]);

        $roles = Role::where('name', '!=', 'Super Admin')->get();
        return \view('auth.user.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', [$user, \auth()->user()]);

        $old_image = $user->image;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $imageName = $request->image->getClientOriginalName();

            $request->file('image')->store('images', 'public');
            $user->image = $imageName;
        }
        $user->syncRoles($request->input('roles'));
        $user->save();

        if ($old_image && $user->image){
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('users.index')->with('status', 'Updated Successfully');

    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', [$user, \auth()->user()]);

        $user->delete();
        return redirect()->back()->with('status', 'Deleted Successfully');
    }
}
