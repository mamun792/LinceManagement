<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\License;

class VerifyLicenseKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next)
    {
        $licenseKey = $request->input('license_key');

        $license = License::where('key', $licenseKey)->first();

        if (! $license || $license->status !== 'active') {
            return response()->json(['error' => 'Invalid or inactive license.'], 403);
        }

        if ($license->expires_at && now()->greaterThan($license->expires_at)) {
            return response()->json(['error' => 'License expired.'], 403);
        }

        return $next($request);
    }
}
