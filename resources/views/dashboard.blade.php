@extends('new')

@section('title', 'EMIS Dashboard')

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
            padding: 18px;
            border-radius: 8px;
            border-left: 6px solid #0b5ed7;
        }

        .kpi-card.warning { border-left-color: #dc3545; }
        .kpi-card.success { border-left-color: #198754; }
        .kpi-card.info { border-left-color: #20c997; }

        .kpi-title {
            font-size: 14px;
            color: #555;
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
            padding: 15px;
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
    <div class="kpi-grid">
        <div class="kpi-card success">
            <div class="kpi-title">Efficiency</div>
            <div class="kpi-value">96.6%</div>
            <small>Productive Time</small>
        </div>

        <div class="kpi-card info">
            <div class="kpi-title">Operational Cost</div>
            <div class="kpi-value">$1,066,041</div>
            <small>Total Cost</small>
        </div>

        <div class="kpi-card">
            <div class="kpi-title">Non-Productive Time</div>
            <div class="kpi-value">13.7%</div>
            <small>Downtime</small>
        </div>

        <div class="kpi-card warning">
            <div class="kpi-title">Safety Incidents</div>
            <div class="kpi-value">3.8%</div>
            <small>Incident Frequency</small>
        </div>
    </div>

    <!-- CHARTS + ASSETS -->
    <div class="dashboard-grid">

        <!-- CHARTS -->
        <div class="charts">

            <div class="card">
                <h3>Operational Trend</h3>
                <canvas id="trendChart"></canvas>
            </div>

            <div class="card">
                <h3>Quality Performance</h3>
                <canvas id="qualityChart"></canvas>
            </div>

        </div>

        <!-- ASSETS -->
        <div class="card">
            <h3>Assets Status</h3>

            <div class="asset-item">
                <span>Asset A</span>
                <span class="asset-value">96.0%</span>
            </div>

            <div class="asset-item">
                <span>Asset B</span>
                <span class="asset-value">89.8%</span>
            </div>

            <div class="asset-item">
                <span>Asset C</span>
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
