<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\Auth\AuthRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends SendController
{
    public function register(RegisterRequest $request){

        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);
        return $this->sendSuccess(['msg' => 'Successful register'], 201);
    }

    public function authenticate(AuthRequest $request)
    {
        $validated = $request->validated();
 
        if (Auth::attempt($validated)) {
            $token = $request->user()->generateToken();
            return $this->sendSuccess(['token' => $token]);
        }
 
        return $this->sendError(['password' => 'Incorrect email or password']);
    }
}
