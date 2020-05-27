<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Appointment;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            if (isset($request['validFrom']) && isset($request['validTo'])) {
                $app = DB::table('appointments')->selectRaw('doctor_id')
                    ->where('id', '!=',$request['exceptFor'])
                    ->where(function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->where('end_time', ">=", $request['validFrom'])
                                ->where('end_time', "<=", $request['validTo']);
                        })->orWhere(function ($query) use ($request) {
                            $query->where('start_time', ">=", $request['validFrom'])
                                ->where('start_time', "<=", $request['validTo']);
                        })->orWhere(function ($query) use ($request) {
                            $query->where('start_time', "<=", $request['validFrom'])
                                ->where('end_time', ">=", $request['validTo']);
                        });
                    })->get()->pluck('doctor_id')->toArray();
            }
            $user = User::whereActive(1)->with(['ownAppointments'])
                ->where(function ($query) use ($request, $app) {
                    $fillables = $this->user->getFillable();

                    foreach ($fillables as $fillable) {
                        if (isset($request[$fillable])) {
                            $query->where($fillable, $request[$fillable]);
                        }
                    }
                    if (isset($request['is_doctor'])) {
                        $query->where('department', "LIKE", "%");
                    }
                    if (isset($request['validFrom']) && isset($request['validTo'])) {
                        $query->whereNotIn('id', $app );
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
