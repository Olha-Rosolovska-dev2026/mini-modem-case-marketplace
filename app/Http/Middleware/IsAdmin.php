<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Admin gate middleware
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Administrator access is required for this area.');
        }

        return $next($request);
    }
}
