<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        try {
            $this->authorize('index', $this->user);
            $user = User::whereActive(1)->where(function ($query) use ($request) {
                $fillables =  $this->user->getFillable();

                foreach ($fillables as $fillable) {
                    if (isset($request[$fillable])) {
                        $query->where($fillable, $request[$fillable]);
                    }
                }
                if(isset($request['is_doctor'])){
                    $query->where('department', "LIKE", "%");
                }
            })->get();
            return response()->json([
                "user" => UserResource::collection($user),
                "count" => count($user)
            ], 200);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'error' => 'Not authorized.'
            ], 403);
        }
    }

    public function show(User $user)
    {
        try {
            $this->authorize('show', $this->user);

            return response()->json([
                "user" => new UserResource($user)
            ], 200);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'error' => 'Not authorized.'
            ], 403);
        }
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $this->authorize('store', $this->user);

            $this->user->fill($request->all());

            if ($this->user->save()) {

                return response()->json([
                    "user" => new UserResource($this->user)
                ], 201);
            } else {
                return response()->json([], 500);
            }
        } catch (AuthorizationException $exception) {
            return response()->json([
                'error' => 'Not authorized.'
            ], 403);
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $this->authorize('update', $user);

            $user->update($request->all());

            if ($user->save()) {
                return response()->json([
                    'data' => new UserResource($user)
                ], 200);
            }
            return response()->json([
            ], 400);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'error' => 'Not authorized.'
            ], 403);
        }

    }


}
