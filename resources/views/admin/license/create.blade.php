@extends('layouts.admin')

@section('title', 'License Manager')

@section('content')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-12">


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Header Section -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4">
                    <h1 class="mb-3 mb-md-0">Create New License</h1>
                    <a href="{{ route('admin.licenses.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>

                <!-- License Form -->
                <form method="POST" action="{{ route('admin.licenses.store') }}" class="needs-validation" novalidate>
                    @csrf

                    <!-- Basic Information -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                <h3 class="h5 mb-0">Basic Information</h3>
                            </div>

                            <div class="row g-4">
                                <!-- License Key -->
                                <div class="col-md-6">
                                    <label for="licenseKey" class="form-label">License Key</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light" id="licenseKey"
                                            name="license_key" value="" readonly aria-describedby="keyHelp">
                                        <button class="btn btn-outline-secondary" type="button" id="copyKeyBtn"
                                            data-bs-toggle="tooltip" title="Copy key">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary" type="button" id="generateKeyBtn"
                                            data-bs-toggle="tooltip" title="Generate new">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                    <div id="keyHelp" class="form-text">Leave blank to auto-generate</div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>
                                            Suspended</option>
                                        <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">Please select a status</div>
                                </div>

                                <!-- Date Inputs -->
                                <div class="col-md-6">
                                    <label for="createdAt" class="form-label">Created At</label>
                                    <input type="datetime-local" class="form-control" id="createdAt" name="created_time"
                                        value="{{ old('created_at', now()->format('Y-m-d\TH:i')) }}">
                                </div>

                                <!-- Expiration -->
                                <div class="col-md-6">
                                    <div class="row g-2 align-items-center">
                                        <div class="col-8">
                                            <label for="expiresAt" class="form-label">Expires At</label>
                                            <input type="datetime-local" class="form-control" id="expiresAt"
                                                name="expires_at" value="{{ old('expires_at') }}"
                                                {{ old('lifetime') ? 'disabled' : '' }}>
                                        </div>
                                        <div class="col-4 pt-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="lifetimeCheckbox"
                                                    name="is_lifetime" value="1"
                                                    {{ old('is_lifetime') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="lifetimeCheckbox">
                                                    Lifetime
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Domain Configuration -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-globe me-2 text-primary"></i>
                        <h3 class="h5 mb-0">Domain Configuration</h3>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-8">
                            <label for="domain" class="form-label">Primary Domain</label>
                            <input type="url" class="form-control {{ $errors->has('domain') ? 'is-invalid' : '' }}"
                                id="domain" name="domain" placeholder="https://example.com" value="{{ old('domain') }}"
                                required>
                            <div class="invalid-feedback">Please enter a valid domain URL</div>
                        </div>
                        <div class="col-md-4">
                            <label for="maxDomains" class="form-label">Max Domains</label>
                            <input type="number"
                                class="form-control {{ $errors->has('max_domains') ? 'is-invalid' : '' }}" id="maxDomains"
                                name="max_domains" value="{{ old('max_domains', 1) }}" min="1" step="1"
                                required>
                            <div class="invalid-feedback">Minimum 1 domain required</div>
                        </div>

                        <div class="col-12">
                            <label for="ipRestrictions" class="form-label">IP Restrictions</label>
                            <textarea class="form-control font-monospace {{ $errors->has('ip_restrictions') ? 'is-invalid' : '' }}"
                                id="ipRestrictions" name="ip_restrictions" rows="3" placeholder="192.168.1.1&#10;10.0.0.1">{{ old('ip_restrictions') }}</textarea>
                            <div class="form-text">One IP per line, empty for no restrictions</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-sticky-note me-2 text-primary"></i>
                        <h3 class="h5 mb-0">Additional Information</h3>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="meta_data" rows="4"
                            placeholder="License-specific notes...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex flex-column-reverse flex-md-row justify-content-between align-items-center py-4">
                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-xmark me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Save License
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>

    <style>
        .form-section {
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 2rem;
        }

        .form-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .invalid-feedback {
            display: block;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap components
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const bsTooltips = [...tooltips].map(tooltip => new bootstrap.Tooltip(tooltip))

            // Lifetime license toggle
            const lifetimeCheckbox = document.getElementById('lifetimeCheckbox')
            const expiresAtInput = document.getElementById('expiresAt')

            lifetimeCheckbox.addEventListener('change', function() {
                expiresAtInput.disabled = this.checked
                if (this.checked) expiresAtInput.value = ''
            })

            // License key generation
            document.getElementById('generateKeyBtn').addEventListener('click', function() {
                const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'
                const segments = [4, 4, 4, 4] // 4 segments of 4 characters
                const key = segments.map(len => {
                    return Array.from({
                            length: len
                        }, () =>
                        chars.charAt(Math.floor(Math.random() * chars.length))
                    ).join('')
                }).join('-')

                document.getElementById('licenseKey').value = key
            })

            // Copy to clipboard
            document.getElementById('copyKeyBtn').addEventListener('click', async function() {
                const key = document.getElementById('licenseKey')
                try {
                    await navigator.clipboard.writeText(key.value)
                    const tooltip = bootstrap.Tooltip.getInstance(this)
                    tooltip.setContent({
                        '.tooltip-inner': 'Copied!'
                    })
                    setTimeout(() => tooltip.hide(), 1000)
                } catch (err) {
                    alert('Failed to copy key')
                }
            })

            // Form validation
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })
    </script>
@endpush
