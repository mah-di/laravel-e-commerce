<?php

namespace App\Http\Middleware;

use App\Helpers\JWTHelper;
use App\Helpers\ResponseHelper;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAuthenticatedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->cookie('token') ?? $request->header('token');

            $payload = JWTHelper::verifyToekn($token);

            if ($payload)
                throw new Exception();

            return $next($request);
        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, 'Can\'t access while logged in.');
        }
    }
}
