<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;

class AuthenticateSanctum
{
    public function handle(Request $request, Closure $next)
    {
        // Check for Bearer token
        $token = $this->getBearerToken($request);

        if ($token) {
            // Verify the token with Sanctum
            $personalAccessToken = Sanctum::personalAccessTokenModel()::findToken($token);

            if ($personalAccessToken && !$personalAccessToken->revoked) {
                // Set the user from the token
                $request->setUserResolver(function () use ($personalAccessToken) {
                    return $personalAccessToken->tokenable;
                });

                return $next($request);
            }
        }

        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    private function getBearerToken(Request $request): ?string
    {
        $header = $request->header('Authorization');

        if ($header && preg_match('/Bearer\s+(\S+)/', $header, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
