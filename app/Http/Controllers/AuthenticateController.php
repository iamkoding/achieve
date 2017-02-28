<?php

namespace App\Http\Controllers;

use Hash;
use JWTAuth;
use App\User;
use App\Http\Requests\AuthenticateUserRequest;
use App\Http\Requests\StoreUserRequest;
use Tymon\JWTAuthExceptions\JWTException;

class AuthenticateController extends ApiController
{
  
    /**
     * @var email string
     * @var password string
     * Attempt a JWT web token request    
     */
    public function authenticate(AuthenticateUserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->respondWithUserError('Invalid credentials');
            }

        } catch (JWTException $e) {
            return $this->respondInternalError('Could not create token, please try again later.');
        }

        return $this->respondSuccessWithArray(compact('token'));
    }

    /**
     * @var email string
     * @var password string
     * @var name string
     * @var city_id int
     * @var vibrate int
     * Attempt to save a new user and give back a jwt web token
     */
    public function store(StoreUserRequest $request)
    {
        $input = $request->only('email', 'password', 'name', 'city_id', 'vibrate');
        $input['password'] = Hash::make($input['password']);

        try {
            $user = User::create($input);
            $credentials = $request->only('email', 'password');
            $token = JWTAuth::attempt($credentials);

        } catch (JWTException $e) {
            return $this->respondInternalError('Could not create token, please try again later.');

        } catch (Exception $e) {
            return $this->respondInternalError('We have a system error. Please try again later.');
        }

        return $this->respondSuccessWithArray([compact('token')]);
    }
}
