<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
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
            $app =[];
            if (isset($request['validFrom']) && isset($request['validTo'])) {
                $from = date('Y/m/d H:i:s',substr($request['validFrom'],0,-3));
                $to = date('Y/m/d H:i:s',substr($request['validTo'],0,-3));

                $app = DB::table('appointments')->selectRaw('doctor_id')
                    ->whereActive(1)
                    ->where(function ($query) use($request){
                        if($request['exceptFor']){
                            $query->where('id', '!=',$request['exceptFor']);
                        }
                    })
                    ->where(function ($query) use ($from, $to) {
                        $query->where(function ($query) use ($from, $to) {
                            $query->where('end_time', ">=", $from)
                                ->where('end_time', "<=", $to);
                        })->orWhere(function ($query) use ($from, $to) {
                            $query->where('start_time', ">=", $from)
                                ->where('start_time', "<=", $to);
                        })->orWhere(function ($query) use ($from, $to) {
                            $query->where('start_time', "<=", $from)
                                ->where('end_time', ">=", $to);
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
                if(isset($this->user->department)){
                    $this->user->permissionGroups()->sync([2]);
                }
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

            if(isset($user->department)){
                $user->permissionGroups()->attach([2]);
            }else {
                $user->permissionGroups()->detach([2]);
            }

            return response()->json([
                    'data' => new UserResource($user)
                ], 200);

        } catch (AuthorizationException $exception) {
            return response()->json([
                'error' => 'Not authorized.'
            ], 403);
        }

    }


}
