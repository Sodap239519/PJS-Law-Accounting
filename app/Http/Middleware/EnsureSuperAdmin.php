<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    /**
     * อนุญาตเฉพาะ super_admin (เช่น จัดการผู้ใช้ระบบ)
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isSuperAdmin()) {
            abort(403, 'ต้องเป็น Super Admin เท่านั้น');
        }

        return $next($request);
    }
}
