    <!-- Content -->
    <div class="container-fluid p-4">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3 mb-md-0">
                <div class="card stat-card total h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-2">Total Licenses</h6>
                                <h3 class="mb-0">1,248</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-key text-primary"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-success"><i class="fas fa-caret-up me-1"></i> 12.5%</span>
                            <span class="text-muted ms-2">vs last month</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3 mb-md-0">
                <div class="card stat-card active h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-2">Active</h6>
                                <h3 class="mb-0">892</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-success"><i class="fas fa-caret-up me-1"></i> 8.3%</span>
                            <span class="text-muted ms-2">vs last month</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3 mb-md-0">
                <div class="card stat-card suspended h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-2">Suspended</h6>
                                <h3 class="mb-0">56</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-pause-circle text-warning"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-danger"><i class="fas fa-caret-down me-1"></i> 2.1%</span>
                            <span class="text-muted ms-2">vs last month</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card expired h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-2">Expired</h6>
                                <h3 class="mb-0">300</h3>
                            </div>
                            <div class="bg-danger bg-opacity-10 p-3 rounded">
                                <i class="fas fa-times-circle text-danger"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-success"><i class="fas fa-caret-up me-1"></i> 5.7%</span>
                            <span class="text-muted ms-2">vs last month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Recent Licenses -->
        <div class="row">
            <!-- License Activity Chart -->
            <div class="col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">License Activity</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                Last 30 Days
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Last 7 Days</a>
                                <a class="dropdown-item" href="#">Last 30 Days</a>
                                <a class="dropdown-item" href="#">Last 90 Days</a>
                                <a class="dropdown-item" href="#">This Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-placeholder" style="height: 300px;">
                            <!-- Chart would go here (Chart.js, etc.) -->
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                <div class="text-center">
                                    <i class="fas fa-chart-line fa-3x mb-2"></i>
                                    <p>License activity chart</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expiring Soon -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="mb-0">Expiring Soon</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">ABC123-XYZ456</div>
                                    <small class="text-muted">example.com</small>
                                </div>
                                <span class="badge bg-warning rounded-pill">3 days</span>
                            </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">DEF789-GHI012</div>
                                    <small class="text-muted">demo.site</small>
                                </div>
                                <span class="badge bg-warning rounded-pill">5 days</span>
                            </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">JKL345-MNO678</div>
                                    <small class="text-muted">test.app</small>
                                </div>
                                <span class="badge bg-warning rounded-pill">7 days</span>
                            </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">PQR901-STU234</div>
                                    <small class="text-muted">client.com</small>
                                </div>
                                <span class="badge bg-warning rounded-pill">8 days</span>
                            </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">VWX567-YZA890</div>
                                    <small class="text-muted">myapp.io</small>
                                </div>
                                <span class="badge bg-warning rounded-pill">10 days</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-sm btn-link">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Licenses and Activity Log -->
        <div class="row">
            <!-- Recent Licenses -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Recent Licenses</h6>
                        <a href="#" class="btn btn-sm btn-link">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>License Key</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-monospace">ABC123-XYZ456</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>2 hours ago</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-monospace">DEF789-GHI012</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>5 hours ago</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-monospace">JKL345-MNO678</td>
                                        <td><span class="badge bg-warning">Suspended</span></td>
                                        <td>1 day ago</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-monospace">PQR901-STU234</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>2 days ago</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-monospace">VWX567-YZA890</td>
                                        <td><span class="badge bg-danger">Expired</span></td>
                                        <td>3 days ago</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Recent Activity</h6>
                        <a href="#" class="btn btn-sm btn-link">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <span class="avatar bg-primary text-white">JD</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">John Doe</h6>
                                            <small class="text-muted">5 min ago</small>
                                        </div>
                                        <p class="mb-1">Created new license <span
                                                class="font-monospace">ABC123-XYZ456</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <span class="avatar bg-success text-white">AS</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">Alice Smith</h6>
                                            <small class="text-muted">1 hour ago</small>
                                        </div>
                                        <p class="mb-1">Suspended license <span
                                                class="font-monospace">JKL345-MNO678</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <span class="avatar bg-info text-white">RJ</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">Robert Johnson</h6>
                                            <small class="text-muted">3 hours ago</small>
                                        </div>
                                        <p class="mb-1">Extended expiration for <span
                                                class="font-monospace">DEF789-GHI012</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <span class="avatar bg-warning text-white">MB</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">Maria Brown</h6>
                                            <small class="text-muted">1 day ago</small>
                                        </div>
                                        <p class="mb-1">Updated IP restrictions for <span
                                                class="font-monospace">PQR901-STU234</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <span class="avatar bg-danger text-white">DW</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">David Wilson</h6>
                                            <small class="text-muted">2 days ago</small>
                                        </div>
                                        <p class="mb-1">Deleted license <span
                                                class="font-monospace">VWX567-YZA890</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
