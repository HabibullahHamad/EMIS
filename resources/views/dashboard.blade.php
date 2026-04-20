@extends('new')

@section('title', 'Executive Management Information System')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Executive Management Information System</h2>
        <div class="d-flex align-items-center">
            <span class="me-3">Welcome, Habibullah</span>
            <i class="bi bi-bell me-2 position-relative">
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">2</span>
            </i>
            <i class="bi bi-envelope position-relative">
                <span class="badge bg-warning position-absolute top-0 start-100 translate-middle">5</span>
            </i>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Documents</h5>
                    <h3 class="text-primary fw-bold">325</h3>
                    <i class="bi bi-building fs-2 text-secondary"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Employees</h5>
                    <h3 class="text-success fw-bold">15,750</h3>
                    <i class="bi bi-people fs-2 text-secondary"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Tasks</h5>
                    <h3 class="text-info fw-bold">980</h3>
                    <i class="bi bi-person-badge fs-2 text-secondary"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Attendance Rate</h5>
                    <h3 class="text-warning fw-bold">92.5%</h3>
                    <i class="bi bi-check-circle fs-2 text-secondary"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Panels -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">Academic Performance</div>
                <div class="card-body">
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">Finance Overview</div>
                <div class="card-body">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts and Updates -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-bold">Recent Updates</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Policy Update: New Curriculum Guidelines</li>
                    <li class="list-group-item">Upcoming Event: Science Fair Next Week</li>
                    <li class="list-group-item">Facility Maintenance Scheduled at Lincoln High</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-bold">System Alerts</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-danger">Low Attendance at Oakwood School</li>
                    <li class="list-group-item text-warning">IT Issue: Server Downtime Reported</li>
                    <li class="list-group-item text-info">Teacher Evaluation Reports Due</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Charts Script -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const performanceCtx = document.getElementById('performanceChart').getContext('2d');
    new Chart(performanceCtx, {
        type: 'bar',
        data: {
            labels: ['Math', 'Science', 'English', 'History'],
            datasets: [{
                label: 'Average Test Scores',
                data: [82, 78, 85, 74],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
            }]
        }
    });

    const financeCtx = document.getElementById('financeChart').getContext('2d');
    new Chart(financeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Gov. Funding', 'Grants', 'Donations'],
            datasets: [{
                data: [60, 25, 15],
                backgroundColor: ['#007bff', '#17a2b8', '#ffc107']
            }]
        }
    });
</script>
@endpush
@endsection
