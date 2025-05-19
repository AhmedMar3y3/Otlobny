<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Store
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $store = Auth::guard('store')->user();
        
        if (!$store) {
            logger('Store middleware: No authenticated store.');
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'غير مصرح: يمكن فقط للمتاجر الوصول إلى هذا المسار'], 403);
            }
            
            return redirect()->route('storeloginPage');
        }

        logger('Store middleware: Store authenticated.', ['store' => $store]);
        return $next($request);
    }
}