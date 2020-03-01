<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {

    }

    public function store(CreateUserRequest $request) {

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

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $this->authorize('update', $user);

            $user->update([
                'name'=> $request->name,
                'address' => $request->address,
                'birthday'=> $request->birthday,
                'password' => $request->password,
            ]);

            if(!$user->save()) {
                return response()->json([
                ], 400);
            }

            return response()->json([
                'data' => new UserResource($user)
            ], 200);
        }catch (AuthorizationException $exception) {
            return response()->json([
                'error' => 'Not Authorized.'
            ], 403);
        }

    }
}
