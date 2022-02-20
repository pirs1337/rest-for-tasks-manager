<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends SendController
{
    public function getAuthUser(){
        $user = Auth::user();

        if ($user) {
            return response()->json(['data' => new UserResource($user)]);
        }

        return $this->sendError(['msg' => 'Not found'], 404);
    }
}
