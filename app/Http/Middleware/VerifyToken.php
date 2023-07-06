<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyToken
{
    //custom trait
    use HttpResponses;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //must put authorization in header the 'my_ultimate_secret_token' as value to proceed
        if ($request->header('Authorization') !== 'my_ultimate_secret_token') {
            return $this->error(null, 'Invalid token!', 404);
        }

        return $next($request);
    }
}