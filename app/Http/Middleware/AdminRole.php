<?php

namespace App\Http\Middleware;

use App\Models\RolePermission;
use Closure;
use Illuminate\Http\Request;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $code)
    {
        $user = auth()->user();
        if ($user->role_id == null) {
            return response()->json(['status' => 0, 'message' => 'forbidden'], 403);
        }
        $permissoins = RolePermission::with(['permission'])->where('role_id', $user->role_id)->get();
        foreach ($permissoins as $permission) {
            if ($permission->permission->code == $code) {
                return $next($request);
            }
        }

        return response()->json(['status' => 0, 'message' => 'forbidden'], 403);
    }
}
