<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class ViewUserData
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = $request->route('user_id');
        // if a user_id is specified, then we need to check for admin or grader roles
        if($userId) {
            $roles = ['administrator', 'grader'];

            // ensure that the user has a required role
            if (!$request->user()->hasRole($roles)) {
                return abort(401, 'Unauthorized action.');
            }

            $request->viewUser = User::findOrFail($userId);
        } else {
            $request->viewUser = $request->user();
        }

        return $next($request);
    }
}
