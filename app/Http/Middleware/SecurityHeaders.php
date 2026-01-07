<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Content Security Policy (CSP)
        $csp = $this->buildContentSecurityPolicy();
        $response->headers->set('Content-Security-Policy', $csp);

        // Strict Transport Security (HSTS)
        // Force HTTPS for 1 year, include subdomains, allow preloading
        if ($request->secure() || config('app.env') === 'production') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // Prevent clickjacking attacks
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Enable XSS protection (legacy browsers)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer policy - send full URL for same-origin, only origin for cross-origin
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy (formerly Feature Policy)
        // Note: 'unload' is not restricted to allow beforeunload event handlers
        $permissionsPolicy = implode(', ', [
            'geolocation=(self)',
            'microphone=()',
            'camera=()',
            'payment=(self)',
            'usb=()',
            'magnetometer=()',
            'gyroscope=()',
            'accelerometer=()',
        ]);
        $response->headers->set('Permissions-Policy', $permissionsPolicy);

        // Remove server information
        $response->headers->remove('X-Powered-By');
        $response->headers->set('X-Powered-By', 'Coffee and Code');

        return $response;
    }

    /**
     * Build Content Security Policy header value
     *
     * @return string
     */
    protected function buildContentSecurityPolicy(): string
    {
        $nonce = base64_encode(random_bytes(16));
        app()->instance('csp-nonce', $nonce);

        $policies = [
            // Default fallback for all resource types
            "default-src 'self'",

            // Scripts: Allow self, inline with nonce, eval for development
            $this->buildScriptSrc(),

            // Styles: Allow self, inline styles, Google Fonts
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net",

            // Images: Allow self, data URIs, blob, external CDNs
            "img-src 'self' data: blob: https: http:",

            // Fonts: Allow self, data URIs, Google Fonts
            "font-src 'self' data: https://fonts.gstatic.com https://fonts.bunny.net",

            // Connect (AJAX/WebSocket): Environment-aware configuration
            $this->buildConnectSrc(),

            // Media: Allow self
            "media-src 'self'",

            // Objects: Block all plugins (Flash, Java, etc.)
            "object-src 'none'",

            // Base URI: Restrict to self
            "base-uri 'self'",

            // Form actions: Allow self (restrict form submissions)
            "form-action 'self'",

            // Frame ancestors: Prevent framing (same as X-Frame-Options)
            "frame-ancestors 'self'",

            // Frames: Allow self and dbdiagram.io
            "frame-src 'self' https://dbdiagram.io",

            // Upgrade insecure requests in production
            config('app.env') === 'production' ? 'upgrade-insecure-requests' : '',
        ];

        return implode('; ', array_filter($policies));
    }

    /**
     * Build connect-src directive based on environment
     *
     * @return string
     */
    protected function buildConnectSrc(): string
    {
        $sources = [
            "'self'",
            // Pusher WebSocket (use leading wildcard for subdomains)
            'https://*.pusher.com',
            'wss://*.pusher.com',
            // Production WebSocket server
            'https://reverb.car-hub.xyz',
            'wss://reverb.car-hub.xyz',
            // Website Carbon API
            'https://api.websitecarbon.com',
        ];

        // Add localhost WebSocket for development
        if (config('app.env') !== 'production') {
            $sources[] = 'ws://localhost:*';
            $sources[] = 'wss://localhost:*';
            $sources[] = 'http://localhost:*';
            $sources[] = 'https://localhost:*';
        }

        return 'connect-src ' . implode(' ', $sources);
    }

    /**
     * Build script-src directive
     *
     * @return string
     */
    protected function buildScriptSrc(): string
    {
        return "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://fonts.googleapis.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com https://js.pusher.com";
    }
}
