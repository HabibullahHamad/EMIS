@extends('new')

@section('title', 'Settings')

@section('content')


<div class="container-fluid">
    <div class="row">

        <!-- SETTINGS SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-light border-end min-vh-100 p-0">
            <div class="list-group list-group-flush">
                <a href="#account" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                    <i class="bi bi-person"></i> Account
                </a>
                <a href="#system" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-gear"></i> System
                </a>
                <a href="#currency" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-currency-exchange"></i> Currency & Locale
                </a>
                <a href="#activities" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-clock-history"></i> Activities & Logs
                </a>
                <a href="#database" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-database"></i> Database
                </a>
                <a href="#reports" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-file-earmark-text"></i> Reports
                </a>
                <a href="#security" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-shield-lock"></i> Security
                </a>
                <a href="#advanced" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-sliders"></i> Advanced
                </a>
                <a href="#about" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-info-circle"></i> About
                </a>
            </div>
        </div>

        <!-- SETTINGS CONTENT -->
        <div class="col-md-9 col-lg-10 p-4">
            <div class="tab-content">

                <!-- ACCOUNT -->
                <div class="tab-pane fade show active" id="account">
                    <h4>Account Settings</h4>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Full Name</label>
                            <input type="text" class="form-control" value="#">
                        </div>
                        <div class="col-md-6">
                            <label>Username</label>
                            <input type="text" class="form-control" value="#" disabled>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Role</label>
                            <input type="text" class="form-control" value="#" disabled>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Change Password</label>
                            <input type="password" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- SYSTEM -->
                <div class="tab-pane fade" id="system">
                    <h4>System Settings</h4>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <label>System Name</label>
                            <input type="text" class="form-control" value="EMIS - Ministry of Education">
                        </div>
                        <div class="col-md-6">
                            <label>Academic Year</label>
                            <select class="form-control">
                                <option>2024 - 2025</option>
                                <option>2025 - 2026</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Default Language</label>
                            <select class="form-control">
                                <option>Dari</option>
                                <option>Pashto</option>
                                <option>English</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Time Zone</label>
                            <select class="form-control">
                                <option>Asia/Kabul</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- CURRENCY -->
                <div class="tab-pane fade" id="currency">
                    <h4>Currency & Localization</h4>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Default Currency</label>
                            <select class="form-control">
                                <option>AFN - Afghani</option>
                                <option>USD - Dollar</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Decimal Precision</label>
                            <input type="number" class="form-control" value="2">
                        </div>
                    </div>
                </div>

                <!-- ACTIVITIES -->
                <div class="tab-pane fade" id="activities">
                    <h4>Activities & Logs</h4>
                    <hr>
                    <p class="text-muted">All system activities are logged for audit purposes.</p>

                    <ul>
                        <li>User login history</li>
                        <li>Data create/update/delete</li>
                        <li>Configuration changes</li>
                    </ul>
                </div>

                <!-- DATABASE -->
                <div class="tab-pane fade" id="database">
                    <h4>Database Management</h4>
                    <hr>

                    <button class="btn btn-primary">
                        <i class="bi bi-download"></i> Backup Database
                    </button>
                    <button class="btn btn-warning ms-2">
                        <i class="bi bi-upload"></i> Restore Backup
                    </button>
                </div>

                <!-- REPORTS -->
                <div class="tab-pane fade" id="reports">
                    <h4>Report Settings</h4>
                    <hr>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" checked>
                        <label class="form-check-label">
                            Lock approved reports
                        </label>
                    </div>
                </div>

                <!-- SECURITY -->
                <div class="tab-pane fade" id="security">
                    <h4>Security Settings</h4>
                    <hr>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" checked>
                        <label class="form-check-label">
                            Enable Two-Factor Authentication
                        </label>
                    </div>

                    <div class="mt-3">
                        <label>Max Login Attempts</label>
                        <input type="number" class="form-control" value="5">
                    </div>
                </div>

                <!-- ADVANCED -->
                <div class="tab-pane fade" id="advanced">
                    <h4>Advanced Settings</h4>
                    <hr>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                            Maintenance Mode
                        </label>
                    </div>
                </div>

                <!-- ABOUT -->
                <div class="tab-pane fade" id="about">
                    <h4>About EMIS</h4>
                    <hr>

                    <p><strong>Version:</strong> 1.0.0</p>
                    <p><strong>Developed By:</strong> EMIS Technical Team</p>
                    <p><strong>Support:</strong> support@emis.gov</p>
                </div>

            </div>

            <div class="mt-4 text-end">
                <button class="btn btn-success">
                    <i class="bi bi-save"></i> Save Changes
                </button>
            </div>
        </div>

    </div>
</div>


@endsection