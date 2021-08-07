<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminAuth extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     * @return mixed
     */
    public function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return 'admin/login';
        }

    }
}
