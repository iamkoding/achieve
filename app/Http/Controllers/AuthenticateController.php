<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuthExceptions\JWTException;

class AuthenticateController extends ApiController
{
  
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->respondUnauthorizedRequest('Invalid credentials');
            }

        } catch (JWTException $e) {
            return $this->respondInternalError('could_not_create_token');
        }

        return $this->respondSuccessWithArray([compact('token')]);
    }
}
