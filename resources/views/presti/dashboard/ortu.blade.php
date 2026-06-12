@extends('presti.layout')

@section('title', 'Dashboard Orang Tua')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary">Dashboard Orang Tua</h3>
    <p class="text-muted">Selamat datang, Wali Murid dari <strong>{{ $siswa->nama }}</strong>!</p>
</div>

<div class="row g-4 mb-4">
    <!-- Profil Anak Card -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
            <div class="text-center pb-3 border-bottom mb-3">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex justify-content-center align-items-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-people fs-1"></i>
                </div>
                <h5 class="fw-bold mb-1">{{ $siswa->nama }}</h5>
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Data Siswa (Anak)</span>
            </div>
            
            <div class="row g-2 text-start small">
                <div class="col-4 text-muted fw-semibold">NIS:</div>
                <div class="col-8 fw-bold">{{ $siswa->nis }}</div>
                
                <div class="col-4 text-muted fw-semibold">Kelas:</div>
                <div class="col-8 fw-bold">{{ $siswa->kelas }}</div>
                
                <div class="col-4 text-muted fw-semibold">HP Orang Tua:</div>
                <div class="col-8 fw-bold">{{ $siswa->no_hp_ortu ?: '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Statistik & Kehadiran Card -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
            <h5 class="fw-bold text-secondary mb-4">Ringkasan Kehadiran Anak</h5>
            
            <!-- Kehadiran Rate -->
            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-semibold text-muted">Persentase Kehadiran (Hadir & Terlambat)</span>
                    <span class="fw-bold text-success">{{ $persentase }}%</span>
                </div>
                <div class="progress rounded-pill" style="height: 12px;">
                    <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: {{ $persentase }}%" aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted d-block mt-2">Total hari efektif absensi: <strong>{{ $total_hari }} hari</strong></small>
            </div>
            
            <!-- KPI breakdown -->
            <div class="row g-2">
                <div class="col-6 col-sm border-end border-light text-center">
                    <small class="text-muted fw-semibold d-block mb-1">Hadir</small>
                    <h4 class="fw-bold text-success mb-0">{{ $hadir }}</h4>
                </div>
                <div class="col-6 col-sm border-end border-light text-center">
                    <small class="text-muted fw-semibold d-block mb-1">Terlambat</small>
                    <h4 class="fw-bold text-warning mb-0">{{ $terlambat }}</h4>
                </div>
                <div class="col-6 col-sm border-end border-light text-center">
                    <small class="text-muted fw-semibold d-block mb-1">Sakit</small>
                    <h4 class="fw-bold text-info mb-0">{{ $sakit }}</h4>
                </div>
                <div class="col-6 col-sm border-end border-light text-center">
                    <small class="text-muted fw-semibold d-block mb-1">Izin</small>
                    <h4 class="fw-bold text-primary mb-0">{{ $izin }}</h4>
                </div>
                <div class="col-6 col-sm text-center">
                    <small class="text-muted fw-semibold d-block mb-1">Alpha</small>
                    <h4 class="fw-bold text-danger mb-0">{{ $alpha }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Absensi Terakhir -->
<div class="card border-0 shadow-sm rounded-4 p-4">
    <h5 class="fw-bold text-secondary mb-3"><i class="bi bi-calendar-check me-1"></i> Riwayat 30 Absensi Terakhir</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Status</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $row)
                    @php
                        $badgeClass = 'bg-success';
                        if ($row->status === 'Terlambat') $badgeClass = 'bg-warning text-dark';
                        elseif ($row->status === 'Sakit' || $row->status === 'Izin') $badgeClass = 'bg-info';
                        elseif ($row->status === 'Alpha') $badgeClass = 'bg-danger';
                    @endphp
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($row->tanggal)) }}</td>
                        <td>{{ $row->jam_masuk ?: '-' }}</td>
                        <td>{{ $row->jam_pulang ?: '-' }}</td>
                        <td><span class="badge {{ $badgeClass }}">{{ $row->status }}</span></td>
                        <td>{{ $row->catatan ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Belum ada riwayat absensi anak.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
