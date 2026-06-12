@extends('presti.layout')

@section('title', 'Analisis Kedisiplinan Kelas')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary mb-1">Analisis Kedisiplinan</h3>
    <p class="text-muted">Statistik rekapitulasi kehadiran dan jam masuk siswa</p>
</div>

<!-- Filter Form -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('presti.analisis.kelas') }}" class="row g-3">
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold text-muted">Filter Kelas</label>
                <select name="kelas" class="form-select rounded-3" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelas_list as $kls)
                        <option value="{{ $kls }}" {{ $kelas_id == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold text-muted">Filter Tanggal</label>
                <div class="input-group">
                    <input type="date" name="tanggal" class="form-control rounded-start-3" value="{{ $tanggal }}" onchange="this.form.submit()">
                    @if($tanggal)
                        <a href="{{ route('presti.analisis.kelas') }}?kelas={{ $kelas_id }}" class="btn btn-outline-danger d-flex align-items-center justify-content-center px-3" title="Hapus Filter Tanggal">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- KPI Cards -->
<div class="row g-3 mb-4">
    @php
        $kpis = [
            ['Hadir', $kpi['hadir'], 'success', 'check-circle'],
            ['Terlambat', $kpi['terlambat'], 'warning', 'clock-history'],
            ['Sakit', $kpi['sakit'], 'info', 'thermometer-half'],
            ['Izin', $kpi['izin'], 'primary', 'envelope'],
            ['Alpha', $kpi['alpha'], 'danger', 'x-circle']
        ];
    @endphp
    @foreach($kpis as $k)
        <div class="col-6 col-md">
            <div class="card border-0 shadow-sm rounded-4 border-start border-{{ $k[2] }} border-4 h-100 bg-white">
                <div class="card-body d-flex justify-content-between align-items-center p-3">
                    <div>
                        <span class="text-muted small fw-semibold">{{ $k[0] }}</span>
                        <h4 class="fw-bold text-{{ $k[2] }} mb-0 mt-1">{{ $k[1] }}</h4>
                    </div>
                    <i class="bi bi-{{ $k[3] }} fs-2 text-{{ $k[2] }} opacity-50"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Chart & Table Row -->
<div class="row g-4 mb-4">
    <!-- Chart -->
    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
            <h5 class="fw-bold mb-3 text-secondary">Rata-rata Jam Masuk Kelas (Jam)</h5>
            <div style="height: 250px;" class="d-flex align-items-center justify-content-center">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Table -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
            <h5 class="fw-bold mb-3 text-secondary">Absensi Kehadiran Per Siswa</h5>
            <div class="table-responsive" style="max-height: 250px;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>Nama</th>
                            <th class="text-center">H</th>
                            <th class="text-center">T</th>
                            <th class="text-center">S</th>
                            <th class="text-center">I</th>
                            <th class="text-center">A</th>
                            <th style="width: 120px;">Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaData as $row)
                            @php
                                $total = $row->total ?: 0;
                                $hadir = $row->hadir ?: 0;
                                $terlambat = $row->terlambat ?: 0;
                                $persen = $total > 0 ? round((($hadir + $terlambat) / $total) * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td class="fw-bold text-dark text-truncate" style="max-width: 150px;">{{ $row->nama }}</td>
                                <td class="text-center"><span class="badge bg-success bg-opacity-10 text-success">{{ $row->hadir }}</span></td>
                                <td class="text-center"><span class="badge bg-warning bg-opacity-10 text-warning">{{ $row->terlambat }}</span></td>
                                <td class="text-center"><span class="badge bg-info bg-opacity-10 text-info">{{ $row->sakit }}</span></td>
                                <td class="text-center"><span class="badge bg-primary bg-opacity-10 text-primary">{{ $row->izin }}</span></td>
                                <td class="text-center"><span class="badge bg-danger bg-opacity-10 text-danger">{{ $row->alpha }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress rounded-pill flex-grow-1" style="height:6px">
                                            <div class="progress-bar bg-success rounded-pill" style="width:{{ $persen }}%"></div>
                                        </div>
                                        <span class="small fw-semibold text-muted">{{ $persen }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">Tidak ada data absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = [];
    const jam = [];

    @foreach($chartData as $d)
        labels.push("{{ $d->nama }}");
        jam.push({{ round($d->rata_jam / 3600, 2) }});
    @endforeach

    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jam Masuk (Format Jam)',
                data: jam,
                borderColor: '#1e3a8a',
                backgroundColor: 'rgba(30, 58, 138, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 24,
                    ticks: {
                        stepSize: 2,
                        callback: function(value) {
                            return value + ':00';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
