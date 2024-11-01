<?php

namespace Wing5wong\KamarDirectoryServices\Middleware;

use Closure;
use Exception;

class JsonOrXml
{
    public function handle($request, Closure $next)
    {
        if (! ($request->wantsJson() || $request->wantsXml())) {
            throw new Exception("Invalid Accept header");
        }

        return $next($request);
    }
}
