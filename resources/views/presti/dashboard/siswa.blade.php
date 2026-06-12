@extends('presti.layout')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary">Dashboard Siswa</h3>
    <p class="text-muted">Selamat datang, {{ $siswa->nama }}!</p>
</div>

<div class="row g-4 mb-4">
    <!-- Profil Card -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
            <div class="text-center pb-3 border-bottom mb-3">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex justify-content-center align-items-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-person-badge fs-1"></i>
                </div>
                <h5 class="fw-bold mb-1">{{ $siswa->nama }}</h5>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">Siswa</span>
            </div>
            
            <div class="row g-2 text-start small">
                <div class="col-4 text-muted fw-semibold">NIS:</div>
                <div class="col-8 fw-bold">{{ $siswa->nis }}</div>
                
                <div class="col-4 text-muted fw-semibold">Kelas:</div>
                <div class="col-8 fw-bold">{{ $siswa->kelas }}</div>
                
                <div class="col-4 text-muted fw-semibold">HP Ortu:</div>
                <div class="col-8 fw-bold">{{ $siswa->no_hp_ortu ?: '-' }}</div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('presti.qr-siswa') }}" class="btn btn-outline-primary w-100 fw-semibold rounded-3">
                    <i class="bi bi-qr-code me-2"></i> Tampilkan QR Code Anda
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik & Kehadiran Card -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
            <h5 class="fw-bold text-secondary mb-4">Ringkasan Kehadiran</h5>
            
            <!-- Kehadiran Rate -->
            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-semibold text-muted">Persentase Kehadiran (Hadir & Terlambat)</span>
                    <span class="fw-bold text-primary">{{ $persentase }}%</span>
                </div>
                <div class="progress rounded-pill" style="height: 12px;">
                    <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: {{ $persentase }}%" aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted d-block mt-2">Dihitung dari total hari efektif belajar: <strong>{{ $total_hari }} hari</strong></small>
            </div>
            
            <!-- KPI breakdown -->
            <div class="row g-3">
                <div class="col-6 col-sm-4 col-md-2.4">
                    <div class="bg-success bg-opacity-10 border border-success border-opacity-10 rounded-3 p-3 text-center">
                        <small class="text-muted fw-semibold d-block mb-1">Hadir</small>
                        <h4 class="fw-bold text-success mb-0">{{ $hadir }}</h4>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-2.4">
                    <div class="bg-warning bg-opacity-10 border border-warning border-opacity-10 rounded-3 p-3 text-center">
                        <small class="text-muted fw-semibold d-block mb-1">Terlambat</small>
                        <h4 class="fw-bold text-warning mb-0">{{ $terlambat }}</h4>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-2.4">
                    <div class="bg-info bg-opacity-10 border border-info border-opacity-10 rounded-3 p-3 text-center">
                        <small class="text-muted fw-semibold d-block mb-1">Sakit</small>
                        <h4 class="fw-bold text-info mb-0">{{ $sakit }}</h4>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-2.4">
                    <div class="bg-primary bg-opacity-10 border border-primary border-opacity-10 rounded-3 p-3 text-center">
                        <small class="text-muted fw-semibold d-block mb-1">Izin</small>
                        <h4 class="fw-bold text-primary mb-0">{{ $izin }}</h4>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-2.4">
                    <div class="bg-danger bg-opacity-10 border border-danger border-opacity-10 rounded-3 p-3 text-center">
                        <small class="text-muted fw-semibold d-block mb-1">Alpha</small>
                        <h4 class="fw-bold text-danger mb-0">{{ $alpha }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Chart -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
    <h5 class="fw-bold text-secondary mb-3">Statistik Keterlambatan Per Bulan (Tahun {{ date('Y') }})</h5>
    <div style="height: 300px;">
        <canvas id="monthlyChart"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    const dataKeterlambatan = {!! json_encode($keterlambatanBulan) !!};

    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Keterlambatan',
                data: dataKeterlambatan,
                backgroundColor: '#f9a825',
                borderColor: '#f57f17',
                borderWidth: 1,
                borderRadius: 4
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
