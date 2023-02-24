<?php

namespace App\Http\Controllers\Api\Auth;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password))
        {
            return response('Incorrect data', Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('api');

        return response([
            'token' => $token->plainTextToken
        ]);
    }
}

