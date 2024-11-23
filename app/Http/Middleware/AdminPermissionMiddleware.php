<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated with the 'admin' guard
        $user = Auth::guard('admin')->user();

        if ($user) {
            // Check if the authenticated user has the required permission
            if ($user->hasPermissionTo($permission)) {
                return $next($request);
            } else {
                // User does not have the required permission
                abort(403, 'You do not have permisssion to do this.');
            }
        } else {
            // User is not authenticated
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect(route('getLogin'));
            }
        }
    }
}
