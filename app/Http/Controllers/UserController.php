<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser($id) {
        $user = User::query()->find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User does not exist']);
        }
        return response()->json(['success' => true, 'user' => new UserResource($user)]);
    }

    public function getUsers () {
        $users = User::query()->get();

        return response()->json(['success' => true, 'users' => new UserCollection($users)]);
    }

}
