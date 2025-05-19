<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponses;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;

class Authenticate extends Middleware
{
    use HttpResponses;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->is('api/*')) {
            return route('login');
        }
        return $this->unauthenticatedResponse();
    }
}
