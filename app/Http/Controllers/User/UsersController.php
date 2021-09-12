<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UsersController extends ApiController
{

    public function index()
    {
        $users = User::all();
        return $this->showAll($users);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ];
        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationTokenCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);
        return $this->showOne($user, 201);
    }

    public function show(User $user)
    {
        return $this->showOne($user, 200);
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'min:5',
            'email' => 'email|unique:users',
            'password' => 'min:8|confirmed',
            'admin' => 'in' . User::REGULAR_USER .', '. User::ADMIN_USER
        ];
        $this->validate($request, $rules);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationTokenCode();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->passoword = bcrypt($request->password);
        }

        if ($request->has('admin')) {
            if (! $user->isVerified()) {
                return response()->json(['error' => 'Only Verified users can become admin', 'code' => 409], 409);
            }
            $user->admin = $request->admin;
        }

        if (! $user->isDirty()){
            return response()->json([
                'error' => 'You need to specify a different value to update',
                'code' => 422
            ], 422);
        }

        $user->save();
        return $this->showOne($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user, 200);
    }

}