<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
 

class Delegate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $delegate = Auth::guard('delegate')->user();
        
        if (!$delegate) {
            logger('delegate middleware: No authenticated delegate.');
            return response()->json(['message' => 'غير مصرح: يمكن فقط للمندوبين الوصول إلى هذا المسار'], 403);
        }
    
        logger('delegate middleware: delegate authenticated.', ['delegate' => $delegate]);
        return $next($request);
    }
}
