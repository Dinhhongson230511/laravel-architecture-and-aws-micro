<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : $this->responseUnAuthorized();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if($jwt = $request->cookie('jwt')) {
            $request->headers->set("Authorization", "Bearer {$jwt}");
        }
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * responseUnAuthorized for api
     *
     * @return JsonResponse
     */
    protected function responseUnAuthorized(): JsonResponse
    {
        return response()->json([
            'message' => __('auth.message.login.error'),
            'status' => Response::HTTP_UNAUTHORIZED
        ], Response::HTTP_UNAUTHORIZED);
    }
}
