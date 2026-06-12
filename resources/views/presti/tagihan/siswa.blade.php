@extends('presti.layout')

@section('title', 'Tagihan Keuangan SPP')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary mb-1">Tagihan Keuangan SPP</h3>
    <p class="text-muted">Pantau data tagihan SPP dan status pembayaran Anda</p>
</div>

<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 border-start border-danger border-4 h-100 bg-white">
            <div class="card-body d-flex justify-content-between align-items-center p-3">
                <div>
                    <span class="text-muted small fw-semibold">Belum Dibayar</span>
                    <h4 class="fw-bold text-danger mb-0 mt-1">Rp {{ number_format($total_belum, 0, ',', '.') }}</h4>
                </div>
                <i class="bi bi-exclamation-circle fs-2 text-danger opacity-50"></i>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 border-start border-warning border-4 h-100 bg-white">
            <div class="card-body d-flex justify-content-between align-items-center p-3">
                <div>
                    <span class="text-muted small fw-semibold">Menunggu Verifikasi</span>
                    <h4 class="fw-bold text-warning mb-0 mt-1">Rp {{ number_format($total_verif, 0, ',', '.') }}</h4>
                </div>
                <i class="bi bi-clock-history fs-2 text-warning opacity-50"></i>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 border-start border-success border-4 h-100 bg-white">
            <div class="card-body d-flex justify-content-between align-items-center p-3">
                <div>
                    <span class="text-muted small fw-semibold">Lunas</span>
                    <h4 class="fw-bold text-success mb-0 mt-1">Rp {{ number_format($total_lunas, 0, ',', '.') }}</h4>
                </div>
                <i class="bi bi-check-circle fs-2 text-success opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<!-- Active Bills -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
    <h5 class="fw-bold text-secondary mb-3"><i class="bi bi-credit-card me-1"></i> Tagihan Aktif</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Tagihan</th>
                    <th>Jenis Pembayaran</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Tenggat Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tagihan_aktif as $row)
                    @php
                        $badgeClass = 'bg-danger';
                        if ($row->status === 'Menunggu Verifikasi') $badgeClass = 'bg-warning text-dark';
                    @endphp
                    <tr>
                        <td class="fw-bold text-dark">{{ $row->nama_tagihan }}</td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $row->jenis_pembayaran }}</span></td>
                        <td class="fw-bold text-primary">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                        <td><span class="badge {{ $badgeClass }}">{{ $row->status }}</span></td>
                        <td>{{ date('d-m-Y', strtotime($row->tenggat_bayar)) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Tidak ada tagihan aktif.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Completed Bills -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <h5 class="fw-bold text-secondary mb-3"><i class="bi bi-journal-text me-1"></i> Riwayat Pembayaran (Lunas)</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Tagihan</th>
                    <th>Jenis Pembayaran</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Tanggal Bayar</th>
                    <th>Metode</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tagihan_lunas as $row)
                    <tr>
                        <td class="fw-bold text-dark">{{ $row->nama_tagihan }}</td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $row->jenis_pembayaran }}</span></td>
                        <td class="fw-bold text-success">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                        <td><span class="badge bg-success">Lunas</span></td>
                        <td>{{ date('d-m-Y H:i', strtotime($row->tanggal_bayar)) }}</td>
                        <td>{{ $row->metode_bayar }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Belum ada riwayat pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
