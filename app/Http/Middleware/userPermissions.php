<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use App\Models\permission;
use View;
use Closure;
class userPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $permissions = permission::where("user_id",session("user_id"))->first();
        View::share('permissions', $permissions);
        return $next($request);
    }
}
