<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\License;
use Carbon\Carbon;

class LicenseService
{

    /**
     * Store a new license in the database.
     *
     * @param array $data
     * @return License
     */
    public function store(array $data): License
    {
        // Auto-generate license key if not provided
        $data['key'] = $data['license_key'] ?? Str::upper(Str::random(4) . '-' . Str::random(4) . '-' . Str::random(4) . '-' . Str::random(4));

        // Normalize lifetime option
        if (isset($data['lifetime'])) {
            $data['expires_at'] = null;
        }

        return License::create([
            'license_key'            => $data['license_key'],
            'domain'         => $data['domain'],
            'status'         => $data['status'],
            'created_time'   => $data['created_time'],
            'expires_at'     => $data['expires_at'],
            'max_domains'    => $data['max_domains'],
            'meta_data'      => json_encode([
                'ip_restrictions' => $data['ip_restrictions'] ?? null,
                'notes'           => $data['notes'] ?? null,
            ]),
            'created_at'     => $data['created_at'] ?? now(),
        ]);
    }


    public function validate(string $licenseKey, string $domain, ?string $ip = null): array
    {
        $license = License::where('key', $licenseKey)->first();

        if (!$license) {
            return ['valid' => false, 'reason' => 'License not found.'];
        }

        if ($license->status !== 'active') {
            return ['valid' => false, 'reason' => 'License inactive.'];
        }

        if ($license->expires_at && now()->gt($license->expires_at)) {
            return ['valid' => false, 'reason' => 'License expired.'];
        }

        if (parse_url($license->domain, PHP_URL_HOST) !== parse_url($domain, PHP_URL_HOST)) {
            return ['valid' => false, 'reason' => 'Domain mismatch.'];
        }

        $meta = json_decode($license->meta_data, true);
        if (!empty($meta['ip_restrictions']) && $ip && !in_array($ip, explode(',', $meta['ip_restrictions']))) {
            return ['valid' => false, 'reason' => 'IP not allowed.'];
        }

        return ['valid' => true];
    }

    public function getAllLicenses()
    {
        return License::latest()->paginate(60);
    }

    public function findLicenseById($id): ?License
    {
        return License::find($id);
    }
}
