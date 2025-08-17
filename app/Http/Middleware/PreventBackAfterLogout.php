<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventBackAfterLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is not authenticated and trying to access protected pages
        if (!Auth::check() && $request->is('admin/*') && !$request->is('admin/login')) {
            return redirect()->route('admin.login')
                ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate, private')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT')
                ->header('X-Frame-Options', 'DENY');
        }

        $response = $next($request);

        // Add anti-cache headers for all admin pages
        if ($request->is('admin/*')) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate, private');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
            $response->headers->set('X-Frame-Options', 'DENY');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Referrer-Policy', 'no-referrer');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
        }

        return $response;
    }
}
