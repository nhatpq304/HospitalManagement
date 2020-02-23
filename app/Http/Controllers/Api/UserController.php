<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function store(CreateUserRequest $request) {

            $user = new User();
            $user->fill($request->all());

            if($user->save()) {
                return response()->json([
                    "user" => new UserResource($user)
                ],201);
            }else {
                return response()->json([],500);
            }

    }
}
