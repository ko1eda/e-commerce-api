<?php

namespace App\Http\Middleware;

use Closure;

class SetCurrency
{
    /**
     * If the user is authenticated and they
     * have a currency set, use that currency
     * for every subsequent request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && isset($request->user()->currency)) {
            config(['app.currency' => $request->user()->currency]);
        }

        return $next($request);
    }
}
