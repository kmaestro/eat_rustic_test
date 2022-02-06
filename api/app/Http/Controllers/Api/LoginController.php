<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->validate(
            [
                'email' => 'required|string',
                'password' => 'required|string',
            ]
        );

        if (!Auth::attempt($login)) {
            return response(['error' => 'Invalid login credentials.']);
        }

        $accessToken = Auth::user()->createToken('authToken');

        return response(['user' => Auth::user(), 'access_token' => $accessToken->plainTextToken]);
    }
}
