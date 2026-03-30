@extends('new')
@section('content')

<link rel="stylesheet" href="public/resources/css/dashboard.css">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>    
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EMIS Dashboard</title>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
      

        /* HEADER */
    .kpi-card {
    background: #94979c;
    padding: 20px 25px;
    border-radius: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.kpi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}

.kpi-title {
    font-size: 14px;
    font-weight: 600;
    color: #555;
}

.kpi-value {
    font-size: 26px;
    font-weight: bold;
    margin: 5px 0;
}

.kpi-card small {
    color: #999;
}

/* Icon */
.kpi-icon {
    font-size: 45px;
    opacity: 0.85;
}
/* end */
      

        .breadcrumb {
            font-size: 13px;
            opacity: 0.9;
        }

        /* MAIN CONTAINER */
        .container {
            padding: 0px;
            margin-left:4px;
            margin-right:4px;
            margin-top: 20px;
            font-family: 'Roboto', sans-serif;
            color: #333;
            
          
        }

        /* KPI CARDS */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .kpi-card {
            background: white;
            padding: 11px;
            border-radius: 8px;
            border-left: 6px solid #0b5ed7;
        }

        .kpi-card.warning { border-left-color: #dc3545; }
        .kpi-card.success { border-left-color: #198754; }
        .kpi-card.info { border-left-color: #20c997; }

        .kpi-title {
            font-size: 14px;
            color: #0847b3;
        }

        .kpi-value {
            font-size: 28px;
            font-weight: bold;
            margin: 10px 0;
        }

        /* DASHBOARD GRID */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 3fr 1fr;
            gap: 15px;
        }

        /* CHARTS */
        .charts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .card {
            background: white;
            padding: 10px;
            border-radius: 8px;
        }

        .card h3 {
            font-size: 15px;
            margin-bottom: 10px;
        }

        /* ASSETS */
        .asset-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .asset-item:last-child {
            border-bottom: none;
        }
        .asset-value {
            font-weight: bold;
        }

        /* RESPONSIVE */
        @media(max-width:1000px) {
            .kpi-grid { grid-template-columns: repeat(2, 1fr); }
            .dashboard-grid { grid-template-columns: 1fr; }
            .charts { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- TOP BAR -->


<!-- CONTENT -->
<div class="container">

    <!-- KPI SECTION -->
  <div class="row g-3">

    <!-- 1. All Tasks -->
    <div class="col-md-3">
        <div class="kpi-card">
            <div>
                <div class="kpi-title">All Tasks</div>  <hr>
                <div class="kpi-value">120</div>
                <small>Total Tasks</small>
            </div>
            <div class="kpi-icon text-primary">
                <i class="fas fa-tasks"></i>
            </div>
        </div>
    </div>

    <!-- 2. System Users -->
    <div class="col-md-3">
        <div class="kpi-card">
            <div>
                <div class="kpi-title">All System Users</div>  <hr>
                <div class="kpi-value">45</div>
                <small>Registered Users</small>
            </div>
            <div class="kpi-icon text-info">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- 3. Employees -->
    <div class="col-md-3">
        <div class="kpi-card">
            <div>
                <div class="kpi-title">All Employees</div>  <hr>
                <div class="kpi-value">32</div>
                <small>Active Staff</small>
            </div>
            <div class="kpi-icon text-success">
                <i class="fas fa-user-tie"></i>
            </div>
        </div>
    </div>
    <!-- 4. Documents -->
    <div class="col-md-3">
        <div class="kpi-card">
            <div>
                <div class="kpi-title">Total Documents</div>  <hr>
                
                <div class="kpi-value">560</div>
                <small>All Records</small>
            </div>
            <div class="kpi-icon text-warning">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>
    </div>

    <!-- 5. Pending Tasks -->
   

    <!-- 6. Completed Tasks -->
    <div class="col-md-3">
        <div class="kpi-card">
            <div>
                <div class="kpi-title">Completed Tasks</div>  <hr>
                <div class="kpi-value">102</div>
                <small>Finished</small>
            </div>
            <div class="kpi-icon text-success">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    <!-- 7 assighned tasks -->
    <div class="col-md-3">
        <div class="kpi-card">
            <div>
                <div class="kpi-title">Assigned Tasks</div>  <hr>
                <div class="kpi-value">25</div>
                <small>In Progress</small>
            </div>
            <div class="kpi-icon text-info">
                <i class="fas fa-user-check"></i>
            </div>
        </div>

        <!-- all incomming Documents  -->
    </div>
    <div class="col-md-3">
        <div class="kpi-card">
            <div>
                <div class="kpi-title">Incoming Documents</div>  <hr>
                <div class="kpi-value">150</div>
                <small>New Records</small>  
                </div>
            <div class="kpi-icon text-primary">
                <i class="fas fa-inbox"></i>
                </div>
                </div>
                </div>
                <!-- all outgoing Documents  -->
                <div class="col-md-3">
        <div class="kpi-card">
            <div>
                <div class="kpi-title">Outgoing Documents</div>  <hr>
                <div class="kpi-value">120</div>
                <small>Sent Records</small>
                </div>
            <div class="kpi-icon text-secondary">
                <i class="fas fa-paper-plane"></i>
                </div>
                </div>
                </div>
                <!-- all pending Documents  -->

</div>

<hr>
    <!-- CHARTS + ASSETS -->
    <div class="dashboard-grid">

        <!-- CHARTS -->
        <div class="charts">

            <div class="card">
                <h3>Operational Trend</h3>
                <canvas id="trendChart"></canvas>
            </div>

            <div class="card">
                <h3>Jobs Graph</h3>
                <canvas id="qualityChart"></canvas>
            </div>
        </div>
        <!-- ASSETS -->
        <div class="card">
            <h3>Tasks Assigned </h3>

            <div class="asset-item">
                <span>Team A</span>
                <span class="asset-value">96.0%</span>
            </div>

            <div class="asset-item">
                <span>Team B</span>
                <span class="asset-value">89.8%</span>
            </div>

            <div class="asset-item">
                <span>Team C</span>
                <span class="asset-value">99.0%</span>
            </div>
        </div>

    </div>
</div>

<!-- CHART SCRIPTS -->
<script>
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun'],
            datasets: [{
                label: 'Performance %',
                data: [85, 88, 90, 93, 95, 96],
                borderWidth: 2,
                tension: 0.4
            }]
        }
    });

    new Chart(document.getElementById('qualityChart'), {
        type: 'bar',
        data: {
            labels: ['Dept A','Dept B','Dept C','Dept D'],
            datasets: [{
                label: 'Quality %',
                data: [92, 88, 95, 90]
            }]
        }
    });
</script>

</body>
</html>


@endsection
