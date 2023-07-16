<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{

    public function index(): View
    {
        $this->authorize('viewAny',\auth()->user());

        $users = User::all();
        return view('auth.user.index',compact('users'));
    }

    public function create(): View
    {
        $this->authorize('create',\auth()->user());
        return \view('auth.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($request->password);
        $validatedData['type'] = 1;

        if ($request->hasFile('image') && $request->image != null){
            $imageName = $request->image->getClientOriginalName();
            $request->image->storeAs('public/images', $imageName);
            $validatedData['image'] = $imageName;
        }
        $user = User::create($validatedData);
        $user->assignRole($request->input('roles'));

        return $request->ajax()
            ? response()->json(
                [
                'status' => 'success',
                'data' =>$user,
                'message' => 'Information saved successfully!'
                ],200)
            : redirect()->route('users.index')->with('status','User Created Successfully.');
    }

    public function show(User $user): View
    {
        return \view('auth.user.show',compact('user'));
    }

    public function edit(User $user): View
    {
        $this->authorize('update',[$user,\auth()->user()]);
        return \view('auth.user.edit',compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
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
        $user->syncRoles($request->input('roles'));

        $user->save();

        return redirect()->route('users.index')->with('status','Updated Successfully');

    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete',[$user,\auth()->user()]);
        $user->delete();
        return redirect()->back()->with('status','Deleted Successfully');
    }
}
