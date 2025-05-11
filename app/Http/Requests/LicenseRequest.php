<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LicenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'license_key'         => 'nullable|string|unique:licenses',
            'status'              => 'required|in:active,suspended,expired',
            'created_time'        => 'required|date',
            'expires_at'          => 'nullable|date|after_or_equal:created_time',
            'is_lifetime'         => 'nullable|boolean', // Use boolean instead of 'in:on'
            'domain'              => 'required|url',
            'max_domains'         => 'required|integer|min:1',
            'ip_restrictions'     => 'nullable|string',
            'meta_data'           => 'nullable|string',
            'last_verified_at'    => 'nullable|date',
            'verification_count'  => 'nullable|integer|min:0',
        ];
    }
}
