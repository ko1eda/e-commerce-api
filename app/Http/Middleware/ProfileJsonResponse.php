<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;


class ProfileJsonResponse
{
    /**
     * Return the reponse and determine if it is a json response
     * If it is and the uri has a ?_debug parameter in it
     * Then append the debugbar infomrmation to the response and return
     * that new response object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (($response instanceof JsonResponse && app('debugbar')->isEnabled()) && $request->has('_debug')) {
            $response->setData($response->getData(true) + [
                '_debugbar' => array_only(app('debugbar')->getData(), 'queries')
            ]);
        }
        return $response;
    }
}
