<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SecureSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip for login routes
        if ($request->routeIs('admin.login*')) {
            return $next($request);
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            return $this->redirectToLogin($request);
        }

        $user = Auth::user();

        // Validate session integrity
        if (!$this->isSessionValid($request, $user)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return $this->redirectToLogin($request, 'Your session has expired. Please login again.');
        }

        // Update last activity
        $request->session()->put('last_activity', now());

        // Check for session timeout warning (5 minutes before expiry)
        $lastActivity = $request->session()->get('last_activity');
        $sessionLifetime = config('session.lifetime');
        $minutesSinceActivity = $lastActivity ? now()->diffInMinutes($lastActivity) : 0;
        
        if ($minutesSinceActivity > ($sessionLifetime - 5)) {
            $request->session()->flash('session_warning', true);
            $request->session()->flash('session_remaining', $sessionLifetime - $minutesSinceActivity);
        }

        return $next($request);
    }

    /**
     * Check if the current session is valid
     */
    private function isSessionValid(Request $request, $user): bool
    {
        // Check basic session data
        if (!$request->session()->has('authenticated') || 
            !$request->session()->has('user_id') ||
            $request->session()->get('user_id') != $user->id) {
            return false;
        }

        // Check session timeout
        $lastActivity = $request->session()->get('last_activity');
        if ($lastActivity && now()->diffInMinutes($lastActivity) > config('session.lifetime')) {
            return false;
        }

        // Check if user agent changed (potential session hijacking)
        $sessionUserAgent = $request->session()->get('user_agent');
        if ($sessionUserAgent && $sessionUserAgent !== $request->userAgent()) {
            return false;
        }

        // Check if user is still active and verified
        if ($user->isEmployee() && !$user->is_verified) {
            return false;
        }

        return true;
    }

    /**
     * Redirect to login with appropriate message
     */
    private function redirectToLogin(Request $request, string $message = null)
    {
        $request->session()->flash('login_required', true);
        
        if ($message) {
            $request->session()->flash('error', $message);
        }

        // For AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'authenticated' => false,
                'message' => $message ?? 'Authentication required',
                'redirect' => route('admin.login')
            ], 401);
        }

        return redirect()->route('admin.login');
    }
}
