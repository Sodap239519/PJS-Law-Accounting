<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * อนุญาตเฉพาะผู้ใช้ที่เป็น admin หรือ super_admin เข้าหลังบ้าน
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isAdmin()) {
            abort(403, 'ไม่มีสิทธิ์เข้าถึงหลังบ้าน');
        }

        return $next($request);
    }
}
