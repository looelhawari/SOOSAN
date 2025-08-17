<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $user = Auth::guard('web')->user();

            // Deny unverified employees
            if ($user->isEmployee() && !$user->is_verified) {
                Auth::guard('web')->logout();
                throw ValidationException::withMessages([
                    'email' => 'Your account is not verified. Please contact the administrator.',
                ]);
            }

            // Allow admin or verified employee
            if ($user->isAdmin() || $user->isEmployee()) {
                $request->session()->regenerate();
                
                // Store session security data
                $request->session()->put('user_agent', $request->header('User-Agent'));
                $request->session()->put('last_activity', now());
                $request->session()->put('login_time', now());
                $request->session()->put('authenticated', true);
                $request->session()->put('user_id', $user->id);
                
                // Handle user preferences
                if ($request->has('language')) {
                    $request->session()->put('locale', $request->language);
                    app()->setLocale($request->language);
                }
                
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Welcome back, ' . $user->name . '!');
            }

            // If user is not an admin or employee, deny access
            Auth::guard('web')->logout();
            throw ValidationException::withMessages([
                'email' => 'You do not have the required permissions to access this area.',
            ]);
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        // Clear all session data
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Logout the user
        Auth::guard('web')->logout();
        
        // Clear any cached data
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        
        // Return response with aggressive cache prevention headers
        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate, private')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT')
            ->header('X-Frame-Options', 'DENY')
            ->header('X-Content-Type-Options', 'nosniff')
            ->header('Clear-Site-Data', '"cache", "storage"');
    }

    /**
     * Check session status for AJAX requests
     */
    public function checkSession(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['valid' => false]);
        }

        $lastActivity = $request->session()->get('last_activity');
        $sessionLifetime = config('session.lifetime');
        
        if ($lastActivity) {
            $minutesSinceActivity = now()->diffInMinutes($lastActivity);
            $remaining = $sessionLifetime - $minutesSinceActivity;
            
            if ($remaining <= 0) {
                return response()->json(['valid' => false]);
            }
            
            return response()->json([
                'valid' => true,
                'warning' => $remaining <= 5,
                'remaining' => $remaining
            ]);
        }
        
        return response()->json(['valid' => true]);
    }

    /**
     * Extend session for AJAX requests
     */
    public function extendSession(Request $request)
    {
        if (Auth::check()) {
            $request->session()->put('last_activity', now());
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 401);
    }
}
