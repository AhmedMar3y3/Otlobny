<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Super
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next): Response
    {
        $super = Auth::guard('super')->user();

        if (!$super) {
            logger('Super middleware: No authenticated super.');
            return response()->json(['message' => 'غير مصرح: يمكن فقط للمشرفين الوصول إلى هذا المسار'], 403);
        }

        logger('Super middleware: Super authenticated.', ['super' => $super]);
        return $next($request);
    }
}
