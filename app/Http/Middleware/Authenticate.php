<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\V1\SendController;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        $response = new SendController;

        throw new HttpResponseException(
            $response->sendError(['msg' => 'Unauthorized'], 401)
        );
    }
}
