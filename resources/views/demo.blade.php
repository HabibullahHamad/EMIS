@extends('new')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">System Settings</h4>

    <div class="row g-3">

        <!-- General Settings -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>General Settings</h6>
                    <p class="text-muted small">System name, logo, language</p>
                    <button class="btn btn-sm btn-primary"
                        onclick="openModal('General Settings','generalSettings')">
                        Configure
                    </button>
                </div>
            </div>
        </div>

        <!-- User Settings -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>User Settings</h6>
                    <p class="text-muted small">Profile & password</p>
                    <button class="btn btn-sm btn-primary"
                        onclick="openModal('User Settings','userSettings')">
                        Configure
                    </button>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Security</h6>
                    <p class="text-muted small">Password & session</p>
                    <button class="btn btn-sm btn-primary"
                        onclick="openModal('Security Settings','securitySettings')">
                        Configure
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
