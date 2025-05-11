<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Services\LicenseService;
use Illuminate\Support\Facades\Cache;

class VerifyLicenseKey
{
    protected $licenseManager;

    public function __construct(LicenseService $licenseManager)
    {
        $this->licenseManager = $licenseManager;
    }

    /**
     * Handle an incoming request with secure license verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get license key from different possible sources
        $licenseKey = $request->input('license_key') ??
            $request->header('X-License-Key') ??
            $request->bearerToken();

        if (!$licenseKey) {
            return response()->json([
                'error' => 'License key is required',
                'code' => 'LICENSE_MISSING'
            ], 401);
        }

        // Get the client domain and IP
        $domain = $request->header('Origin') ?? $request->server('SERVER_NAME');
        $clientIp = $request->ip();

        // Cache results to reduce database load (1 minute)
        $cacheKey = 'license_validation:' . md5($licenseKey . $domain . $clientIp);
        $result = Cache::remember($cacheKey, 60, function () use ($licenseKey, $domain, $clientIp) {
            return $this->licenseManager->validate($licenseKey, $domain, $clientIp);
        });

        if (!$result['valid']) {
            return response()->json([
                'error' => $result['reason'] ?? 'Invalid license',
                'code' => 'LICENSE_INVALID',
                'details' => $result['valid'] === false ? $result : null
            ], 403);
        }

        // Add license info to the request for controllers to use
        $request->attributes->add(['license_info' => $result]);

        return $next($request);
    }
}
