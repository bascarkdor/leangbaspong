<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanManage
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->canManage()) {
            if ($request->expectsJson()) {
                abort(403, 'Access denied. Student accounts have read-only access.');
            }

            return redirect()->route('students.index')
                ->with('error', 'Access Denied: As a Student, you have Read-Only permissions and cannot add, edit, or delete records.');
        }

        return $next($request);
    }
}
