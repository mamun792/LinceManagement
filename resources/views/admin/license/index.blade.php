@extends('layouts.admin')

@section('title', 'License Manager')

@section('content')
    <div class="container-fluid p-4">
        <!-- Header -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <h1 class="h2 mb-0">License Management</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.licenses.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>New License
                </a>
                <a href="#" class="btn btn-outline-secondary">
                    <i class="fas fa-file-export me-2"></i>Export
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended
                            </option>
                            <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="License key or domain..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Expiration</label>
                        <select name="expiration" class="form-select">
                            <option value="">All</option>
                            <option value="expiring" {{ request('expiration') === 'expiring' ? 'selected' : '' }}>Expiring
                                Soon</option>
                            <option value="expired" {{ request('expiration') === 'expired' ? 'selected' : '' }}>Already
                                Expired</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.licenses.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- License Table -->
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            {{-- <th>License Key</th> --}}
                            <th>Status</th>
                            <th>Domain</th>
                            <th>Expires At</th>
                            <th>Last Check</th>
                            <th>
                                Check Status
                            </th>
                            <th>Usage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($licenses as $license)
                            <tr>
                                {{-- <td class="font-monospace">{{ $license->license_key }}</td> --}}
                                <td>
                                    @php
                                        $statusClasses = [
                                            'active' => 'success',
                                            'suspended' => 'warning',
                                            'expired' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusClasses[$license->status] ?? 'secondary' }}">
                                        {{ ucfirst($license->status) }}
                                    </span>
                                </td>
                                <td>{{ $license->domain ?? '-' }}</td>
                                <td>
                                    @if ($license->expires_at)
                                        {{ $license->expires_at->format('Y-m-d') }}
                                        @php
                                            $diffInDays = $license->expires_at->diffInDays(now(), false);
                                        @endphp
                                        @if ($diffInDays > 0)
                                            <span class="text-danger">(expired {{ abs($diffInDays) }} days ago)</span>
                                        @else
                                            <span class="text-warning">(in {{ abs($diffInDays) }} days)</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Lifetime</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- api check for project a,project b... --}}
                                    <button class="btn btn-sm btn-link check-status-btn" data-id="{{ $license->id }}">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </td>
                                <td>{{ $license->updated_at->diffForHumans() }}</td>
                                <td>{{ $license->used_domains ?? 0 }}/{{ $license->max_domains }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.licenses.show', $license) }}" class="btn btn-sm btn-link">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.licenses.edit', $license) }}" class="btn btn-sm btn-link">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.licenses.destroy', $license) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    No licenses found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($licenses->hasPages())
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div class="d-none d-md-block">
                        <p class="mb-0 text-muted">
                            Showing {{ $licenses->firstItem() }} to {{ $licenses->lastItem() }} of
                            {{ $licenses->total() }} results
                        </p>
                    </div>
                    <nav>
                        <ul class="pagination mb-0">
                            <li class="page-item {{ $licenses->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $licenses->previousPageUrl() }}">Previous</a>
                            </li>
                            <li class="page-item {{ $licenses->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $licenses->nextPageUrl() }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.check-status-btn').forEach(btn => {
                btn.addEventListener('click', async function() {
                    const id = this.dataset.id;
                    const button = this;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                    try {
                        const res = await fetch(`http://127.0.0.1:8001/api/license-check`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json'
                            }
                        });

                        const data = await res.json();

                        if (res.ok) {
                            alert('✅ ' + data.message);
                            window.location.reload();
                        } else {
                            alert('❌ ' + data.message);
                        }
                    } catch (e) {
                        alert('🚨 Failed to check status: ' + e.message);
                    } finally {
                        button.innerHTML = '<i class="fas fa-sync-alt"></i>';
                    }
                });
            });
        });
    </script>

@endsection
