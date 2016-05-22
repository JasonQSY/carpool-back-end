<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Session\Session;
use App\JsonGeneral;

class ListMiddleware
{
    public function __construct(JsonGeneral $jsonGeneral) {
        $this->jsonGeneral = $jsonGeneral;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $session = new Session();
        if ($session->has('uid')) {
            return $next($request);
        } else {
            return $this->jsonGeneral->show_error("Sessions Outdated or Invalid");
        }
    }
}
