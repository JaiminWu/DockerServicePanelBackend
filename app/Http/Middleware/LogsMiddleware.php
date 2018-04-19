<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Log;
use Closure;

class LogsMiddleware
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
        $log = new Log;
        $log->operator = 'Tester';
        $log->url = $request->fullUrl();
        $log->method = strtolower($request->method());
        $log->save();
        return $next($request);
    }
}
