<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Enum\mediaType;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'error' => 'Login information is not correct.'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return response()->json([
            'token' => $tokenResult->accessToken
        ], 200);
    }

    function getUser(Request $request)
    {
        $user = $request->user()->load(['media' => function ($q) {
            $q->where('media_type', '=', mediaType::$IMAGE);
        }]);

        return response()->json([
            'user' => new UserResource($user)
        ], 200);
    }
}
