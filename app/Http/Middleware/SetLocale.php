<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    /**
     * If the user is authenticated and they
     * have a locale set, use that locale
     * for every subsequent request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && isset($request->user()->locale)) {
            config(['app.locale' => $request->user()->locale]);
        }

        return $next($request);
    }
}
