<?php

namespace Wing5wong\KamarDirectoryServices\Middleware;

use Closure;
use Exception;

class JsonOrXml
{
    public function handle($request, Closure $next)
    {
        if (! ($request->isJson() || $request->isXml())) {
            throw new Exception("Invalid Content-Type header");
        }

        return $next($request);
    }
}
