<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Vendor gate middleware
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsVendor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user || (! $user->isVendor() && ! $user->isAdmin())) {
            abort(403, 'A seller account is required for this area.');
        }

        return $next($request);
    }
}
