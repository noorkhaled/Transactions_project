<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Index function is used here to retrieve all users in DB
    public function index()
    {
        $users = User::all();
        if (!$users) {
            return response()->json([
                'success' => false,
                'message' => "not users found"
            ]);
        }
        return response()->json([
            'success' => true,
            'users' => $users
        ], 201);
    }

    //store function is to create new user
    public function store(Request $request, UserRequest $usersRequest)
    {
        if (!$request->validate($usersRequest->rules())) {
            return response()->json([
                'success' => false,
                'message' => 'cannot create user',
            ]);
        }
        $user = User::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'user Created successfully',
            'user' => $user
        ], 201);
    }

    //show function is used to retrieve a specific user by it`s ID
    public function show($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "Cannot locate user with ID: '$userId'"
            ]);
        }
        return response()->json([
            'success' => true,
            'user' => $user
        ], 201);
    }

    //update function is to first retrieve a specific user by ID like show give it the attributes i want to update
    public function update(Request $request, User $user, UserRequest $usersRequest)
    {
        $originalAttributes = $user->getOriginal();
        if (!$request->validate($usersRequest->rules())) {
            return response()->json([
                    'success' => false,
                    'message' => 'Cannot update user']
                , 201);
        }
        $user->update($request->all());
        $updatedAttributes = collect($user->getAttributes())
            ->filter(function ($value, $key) use ($originalAttributes) {
                return $originalAttributes[$key] != $value;
            });
        return response()->json([
            'success' => true,
            'user' => $user,
            'message' => 'User Updated successfully',
            'updated attributes' => $updatedAttributes
        ], 201);
    }

    //delete function is used to delete a specific user with it`s ID
    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "cannot find user with id: '$id'"
            ], 201);
        }
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => "user with id: '$id' deleted",
        ], 201);
    }
}
