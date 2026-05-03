<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Add baseline browser security headers to every web response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $headers = [
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(), payment=(), usb=()',
            'Content-Security-Policy' => implode('; ', [
                "default-src 'self'",
                "base-uri 'self'",
                "object-src 'none'",
                "frame-ancestors 'self'",
                "form-action 'self'",
                "img-src 'self' data: https:",
                "font-src 'self' https://fonts.bunny.net data:",
                "style-src 'self' 'unsafe-inline' https://fonts.bunny.net",
                "script-src 'self' 'unsafe-inline'",
                "connect-src 'self' http://localhost:* ws://localhost:*",
            ]),
        ];

        foreach ($headers as $name => $value) {
            $response->headers->set($name, $value);
        }

        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
