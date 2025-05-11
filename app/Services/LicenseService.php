<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\License;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;


class LicenseService
{


    private string $encryptionKey;

    public function __construct()
    {
        // Use a dedicated encryption key for licenses
        $this->encryptionKey = config('app.license_key') ?? env('LICENSE_ENCRYPTION_KEY');
    }

    /**
     * Generate a cryptographically secure license key
     */
    private function generateLicenseKey(): string
    {
        // Generate a more secure random value with higher entropy
        $randomBytes = random_bytes(32);
        $hash = hash('sha256', $randomBytes . microtime(true) . mt_rand());

        // Format it for readability while maintaining uniqueness
        return implode('-', [
            substr($hash, 0, 8),
            substr($hash, 8, 4),
            substr($hash, 12, 4),
            substr($hash, 16, 4),
            substr($hash, 20, 12)
        ]);
    }

    /**
     * Encrypt sensitive license data
     */
    private function encryptLicenseData(array $data): string
    {
        return Crypt::encryptString(json_encode($data));
    }

    /**
     * Create digital signature for license validation
     */
    private function signLicense(string $licenseKey, string $domain): string
    {
        return hash_hmac('sha256', $licenseKey . $domain, $this->encryptionKey);
    }

    /**
     * Store a new license with enhanced security
     */
    public function store(array $data): License
    {
        // Generate cryptographically secure license key if not provided
        $licenseKey = $data['license_key'] ?? $this->generateLicenseKey();

        // Create a hashed version for secure storage
        $hashedKey = Hash::make($licenseKey);

        // Handle lifetime licenses
        $isLifetime = isset($data['lifetime']) && $data['lifetime'];
        if ($isLifetime) {
            $data['expires_at'] = null;
            $data['is_lifetime'] = true;
        } else {
            $data['is_lifetime'] = false;
        }

        // Encrypt metadata
        $metaData = [
            'ip_restrictions' => $data['ip_restrictions'] ?? null,
            'notes' => $data['notes'] ?? null,
            'created_ip' => request()->ip(),
            'signature' => $this->signLicense($licenseKey, $data['domain']),
        ];

        // Store only the hashed key in the database, but return the plaintext
        $license = License::create([
            'license_key' => $hashedKey, // Store hashed version
            'domain' => $data['domain'],
            'status' => $data['status'] ?? 'active',
            'created_time' => $data['created_time'] ?? now(),
            'expires_at' => $data['expires_at'] ??  null,
            'is_lifetime' => $data['is_lifetime'] ?? false,
            'max_domains' => $data['max_domains'] ?? 1,
            'meta_data' => $this->encryptLicenseData($metaData),
            'created_at' => $data['created_at'] ?? now(),
            'last_verified_at' => null,
            'verification_count' => 0,
        ]);

        // Return object with the plaintext license key for the user
        $license->plaintext_key = $licenseKey;

        return $license;
    }

    /**
     * Validate a license with enhanced security
     */
    public function validate(string $licenseKey, string $domain, ?string $ip = null): array
    {
        // Rate limiting to prevent brute force attacks
        $cacheKey = 'license_attempts:' . md5($licenseKey . $domain . ($ip ?? ''));
        $attempts = Cache::get($cacheKey, 0);

        if ($attempts > 10) {
            return ['valid' => false, 'reason' => 'Too many validation attempts. Try again later.'];
        }

        Cache::put($cacheKey, $attempts + 1, now()->addMinutes(15));

        // Find license by key pattern (since we can't directly query the hash)
        $licenses = License::all();
        $license = null;

        foreach ($licenses as $potentialLicense) {
            if (Hash::check($licenseKey, $potentialLicense->license_key)) {
                $license = $potentialLicense;
                break;
            }
        }

        if (!$license) {
            return ['valid' => false, 'reason' => 'License not found.'];
        }

        // Basic validations
        if ($license->status !== 'active') {
            return ['valid' => false, 'reason' => 'License inactive.'];
        }

        // Never check expiration for lifetime licenses
        if (!$license->is_lifetime && $license->expires_at && now()->gt($license->expires_at)) {
            return ['valid' => false, 'reason' => 'License expired.'];
        }

        // Domain validation with normalized host comparison
        $licenseHost = parse_url($license->domain, PHP_URL_HOST) ?: $license->domain;
        $requestHost = parse_url($domain, PHP_URL_HOST) ?: $domain;

        // Enhanced domain validation with wildcard support
        $isValidDomain = false;
        if (strpos($licenseHost, '*') !== false) {
            // Wildcard domain pattern matching
            $pattern = '/^' . str_replace('\*', '.*', preg_quote($licenseHost, '/')) . '$/i';
            $isValidDomain = preg_match($pattern, $requestHost);
        } else {
            $isValidDomain = strtolower($licenseHost) === strtolower($requestHost);
        }

        if (!$isValidDomain) {
            return ['valid' => false, 'reason' => 'Domain mismatch.'];
        }

        try {
            // Decrypt and verify metadata
            $meta = json_decode(Crypt::decryptString($license->meta_data), true);

            // Verify digital signature
            $expectedSignature = $this->signLicense($licenseKey, $license->domain);
            if ($meta['signature'] !== $expectedSignature) {
                return ['valid' => false, 'reason' => 'License integrity check failed.'];
            }

            // IP restriction check
            if (!empty($meta['ip_restrictions']) && $ip) {
                $allowedIps = is_array($meta['ip_restrictions'])
                    ? $meta['ip_restrictions']
                    : explode(',', $meta['ip_restrictions']);

                if (!in_array($ip, $allowedIps)) {
                    return ['valid' => false, 'reason' => 'IP not allowed.'];
                }
            }

            // Update verification stats
            $license->verification_count += 1;
            $license->last_verified_at = now();
            $license->save();

            // All checks passed
            return [
                'valid' => true,
                'expires_at' => $license->expires_at ? $license->expires_at->toDateTimeString() : null,
                'is_lifetime' => $license->is_lifetime,
                'domain' => $license->domain,
                'max_domains' => $license->max_domains,
                'duration_display' => $license->duration_display,
            ];
        } catch (\Exception $e) {
            // Log error but don't expose details
            Log::error('License validation error: ' . $e->getMessage());
            return ['valid' => false, 'reason' => 'License validation error.'];
        }
    }

    public function getAllLicenses()
    {
        return License::latest()->paginate(60)->through(function ($license) {
            // We can't decrypt a bcrypt hash - it's one-way
            // The plaintext_key will remain null
            return $license;
        });
    }


    public function findLicenseById($id): ?License
    {
        return License::find($id);
    }

    // deactivate
    public function deactivate(License $license): bool
    {
        //enum('active', 'suspended', 'revoked
        $license->status = 'suspended';
        return $license->save();
    }

    public function activate(License $license): bool
    {
        //enum('active', 'suspended', 'revoked
        $license->status = 'active';
        return $license->save();
    }

    // update
    public function update(License $license, array $data): bool
    {
        // Update license details
        $license->domain = $data['domain'] ?? $license->domain;
        $license->status = $data['status'] ?? $license->status;
        $license->expires_at = isset($data['expires_at']) ? Carbon::parse($data['expires_at']) : $license->expires_at;
        $license->is_lifetime = isset($data['is_lifetime']) ? (bool)$data['is_lifetime'] : $license->is_lifetime;
        $license->max_domains = $data['max_domains'] ?? $license->max_domains;

        // Determine which license key to use for signature
        $licenseKey = $data['license_key'] ?? null;

        // Only generate signature if plaintext key is available
        $signature = null;
        if ($licenseKey && is_string($licenseKey)) {
            $signature = $this->signLicense($licenseKey, $license->domain);
        }

        // Encrypt metadata
        $metaData = [
            'ip_restrictions' => $data['ip_restrictions'] ?? null,
            'notes' => $data['notes'] ?? null,
            'created_ip' => request()->ip(),
            'signature' => $signature,
        ];

        // Update meta_data field
        $license->meta_data = $this->encryptLicenseData($metaData);

        return $license->save();
    }
}
