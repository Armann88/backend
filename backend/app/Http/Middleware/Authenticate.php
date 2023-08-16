<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

//chavtarizovni request pashtpanum

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string   //1
    {
        return $request->expectsJson() ? null : route('login');
    }
    public function handle($request,Closure $next, ...$gurds) //$gurds aftarizovniya te voch +-
    {
        if ($token = $request->cookie('token')) {
            $request->headers->set('Authorzation','Bearer' . $token);
        }
        $this->authenticate($request,$gurds);
        return $next($request);
    }
}
