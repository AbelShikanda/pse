<?php

namespace App\Http\Middleware;

use App\Models\Review;
use App\Models\ReviewToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Closure;

class ReviewMiddleware
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
        $token = ReviewToken::where('token', $request->input('token'))->first();

        if (!$token || !$token->isValid()) {
            return redirect('/')->with('message', 'Invalid or used review token.');
        }

        return $next($request);
    }
}
