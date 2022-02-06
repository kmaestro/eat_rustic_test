<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class AuthenticateApi extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        $token = $request->query('api_token');

        if (empty($token)) {
            $token = $request->bearerToken();
        }

        dump(Auth::user());
    }
}
