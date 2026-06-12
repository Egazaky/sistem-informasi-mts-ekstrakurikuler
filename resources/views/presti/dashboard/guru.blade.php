@extends('presti.layout')

@section('title', 'Dashboard Guru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-0 text-primary">Dashboard Guru</h3>
        <p class="text-muted mb-0">Selamat datang kembali, Guru!</p>
    </div>
    
    <!-- Filter -->
    <form method="GET" action="{{ route('presti.dashboard.guru') }}" class="d-flex align-items-center gap-2">
        <label class="text-muted fw-semibold text-nowrap mb-0">Periode Data:</label>
        <select name="filter_waktu" class="form-select" onchange="this.form.submit()">
            <option value="hari_ini" {{ $filter_waktu === 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
            <option value="semua" {{ $filter_waktu === 'semua' ? 'selected' : '' }}>Total Semua Waktu</option>
        </select>
    </form>
</div>

<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <!-- Hadir -->
    <div class="col-6 col-lg">
        <div class="card border-0 shadow-sm rounded-4 border-start border-success border-4 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Hadir</span>
                    <h3 class="fw-bold text-success mb-0 mt-1">{{ $total_hadir }}</h3>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success">
                    <i class="bi bi-check-circle fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Terlambat -->
    <div class="col-6 col-lg">
        <div class="card border-0 shadow-sm rounded-4 border-start border-warning border-4 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Terlambat</span>
                    <h3 class="fw-bold text-warning mb-0 mt-1">{{ $total_terlambat }}</h3>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 p-3 text-warning">
                    <i class="bi bi-clock-history fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Sakit -->
    <div class="col-6 col-lg">
        <div class="card border-0 shadow-sm rounded-4 border-start border-info border-4 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Sakit</span>
                    <h3 class="fw-bold text-info mb-0 mt-1">{{ $total_sakit }}</h3>
                </div>
                <div class="rounded-circle bg-info bg-opacity-10 p-3 text-info">
                    <i class="bi bi-thermometer-half fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Izin -->
    <div class="col-6 col-lg">
        <div class="card border-0 shadow-sm rounded-4 border-start border-primary border-4 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Izin</span>
                    <h3 class="fw-bold text-primary mb-0 mt-1">{{ $total_izin }}</h3>
                </div>
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary">
                    <i class="bi bi-envelope fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Alpha -->
    <div class="col-6 col-lg">
        <div class="card border-0 shadow-sm rounded-4 border-start border-danger border-4 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Alpha</span>
                    <h3 class="fw-bold text-danger mb-0 mt-1">{{ $total_alpha }}</h3>
                </div>
                <div class="rounded-circle bg-danger bg-opacity-10 p-3 text-danger">
                    <i class="bi bi-x-circle fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <!-- Donut Chart -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h5 class="fw-bold mb-3 text-secondary">Breakdown Kehadiran</h5>
            <div class="position-relative d-flex justify-content-center align-items-center" style="height: 250px;">
                <canvas id="donutChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Line Chart -->
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h5 class="fw-bold mb-3 text-secondary">Tren Kehadiran (Sen-Jum)</h5>
            <div style="height: 250px;">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Bar Chart -->
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h5 class="fw-bold mb-3 text-secondary">Keterlambatan (Sen-Jum)</h5>
            <div style="height: 250px;">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Donut Chart
    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Terlambat', 'Sakit', 'Izin', 'Alpha'],
            datasets: [{
                data: {!! json_encode($donutData) !!},
                backgroundColor: ['#2e7d32', '#f9a825', '#0288d1', '#1565c0', '#c62828'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // 2. Line Chart
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
            datasets: [{
                label: 'Hadir',
                data: {!! json_encode($hadirPerHari) !!},
                fill: true,
                borderColor: '#2e7d32',
                backgroundColor: 'rgba(46, 125, 50, 0.15)',
                tension: 0.3,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // 3. Bar Chart
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
            datasets: [{
                label: 'Terlambat',
                data: {!! json_encode($terlambatPerHari) !!},
                backgroundColor: '#f9a825',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endsection
