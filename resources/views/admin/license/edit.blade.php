@extends('layouts.admin')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Edit License</h1>
                <a href="{{ route('admin.licenses.show', $license->id) }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Back to Details
                </a>
            </div>

            <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('admin.licenses.update', $license->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="px-4 py-5 sm:p-6">
                        @if ($errors->any())
                            <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">
                                            There were {{ $errors->count() }} errors with your submission
                                        </h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="license_key" class="block text-sm font-medium text-gray-700">
                                    License Key
                                </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="license_key" id="license_key"
                                        value="{{ old('license_key', $license->license_key) }}"
                                        class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 rounded-md sm:text-sm border-gray-300">
                                    <button type="button" id="generate_license_key"
                                        class="ml-3 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Generate Key
                                    </button>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Changing the license key will invalidate the current key.
                                </p>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="domain" class="block text-sm font-medium text-gray-700">
                                    Domain
                                </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="url" name="domain" id="domain"
                                        value="{{ old('domain', $license->domain) }}"
                                        class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 rounded-md sm:text-sm border-gray-300">
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    The domain where this license is being used.
                                </p>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="status" class="block text-sm font-medium text-gray-700">
                                    Status
                                </label>
                                <div class="mt-1">
                                    <select id="status" name="status"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="active"
                                            {{ old('status', $license->status) === 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $license->status) === 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                        <option value="suspended"
                                            {{ old('status', $license->status) === 'suspended' ? 'selected' : '' }}>
                                            Suspended</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="max_domains" class="block text-sm font-medium text-gray-700">
                                    Max Domains
                                </label>
                                <div class="mt-1">
                                    <input type="number" name="max_domains" id="max_domains" min="1"
                                        value="{{ old('max_domains', $license->max_domains) }}"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Maximum number of domains this license can be used on.
                                </p>
                            </div>

                            <div class="sm:col-span-3">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="is_lifetime" name="is_lifetime" type="checkbox"
                                            {{ old('is_lifetime', $license->is_lifetime) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_lifetime" class="font-medium text-gray-700">Lifetime License</label>
                                        <p class="text-gray-500">Check this if the license never expires.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3" id="expires_at_container">
                                <label for="expires_at" class="block text-sm font-medium text-gray-700">
                                    Expiration Date
                                </label>
                                <div class="mt-1">
                                    <input type="datetime-local" name="expires_at" id="expires_at"
                                        value="{{ old('expires_at', $license->expires_at ? date('Y-m-d\TH:i', strtotime($license->expires_at)) : '') }}"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Leave empty for lifetime licenses.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('admin.licenses.show', $license->id) }}"
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update License
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isLifetimeCheckbox = document.getElementById('is_lifetime');
            const expiresAtContainer = document.getElementById('expires_at_container');
            const expiresAtInput = document.getElementById('expires_at');

            function toggleExpirationDate() {
                if (isLifetimeCheckbox.checked) {
                    expiresAtContainer.classList.add('opacity-50');
                    expiresAtInput.disabled = true;
                    expiresAtInput.value = '';
                } else {
                    expiresAtContainer.classList.remove('opacity-50');
                    expiresAtInput.disabled = false;
                }
            }

            // Initial state
            toggleExpirationDate();

            // Listen for changes
            isLifetimeCheckbox.addEventListener('change', toggleExpirationDate);

            // License key input validation
            document.getElementById('license_key').addEventListener('input', function() {
                this.value = this.value.replace(/[^a-zA-Z0-9-]/g, '');
            });

            // License key generation
            document.getElementById('generate_license_key').addEventListener('click', function() {
                const licenseKeyInput = document.getElementById('license_key');
                const generatedKey = generateLicenseKey();
                licenseKeyInput.value = generatedKey;
            });

            // Function to generate a secure random license key
            function generateLicenseKey() {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                const keyLength = 24;
                let result = '';

                // Generate 4 groups of 6 characters separated by hyphens
                for (let group = 0; group < 4; group++) {
                    for (let i = 0; i < 6; i++) {
                        result += chars.charAt(Math.floor(Math.random() * chars.length));
                    }

                    // Add hyphen between groups, but not after the last group
                    if (group < 3) {
                        result += '-';
                    }
                }

                return result;
            }
        });
    </script>
@endsection
