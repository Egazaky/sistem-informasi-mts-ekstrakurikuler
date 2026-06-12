@extends('presti.layout')

@section('title', 'Tagihan Keuangan Anak - Wali Murid')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary mb-1">Tagihan Keuangan Anak</h3>
    <p class="text-muted">Pantau rincian tagihan SPP dan lakukan konfirmasi pembayaran bukti transfer untuk Ananda <strong>{{ $siswa->nama }}</strong></p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

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
                    <th class="text-end">Konfirmasi Bayar</th>
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
                        <td class="text-end">
                            @if($row->status === 'Belum Bayar')
                                <button type="button" class="btn btn-sm btn-primary fw-semibold rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $row->id }}">
                                    <i class="bi bi-upload me-1"></i> Upload Bukti
                                </button>
                            @else
                                <span class="text-muted small"><i class="bi bi-hourglass-split me-1"></i> Menunggu Admin</span>
                            @endif
                        </td>
                    </tr>

                    <!-- Upload Proof Modal -->
                    <div class="modal fade" id="uploadModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0">
                                <div class="modal-header border-bottom-0 pb-0">
                                    <h5 class="modal-title fw-bold text-primary">Upload Bukti Transfer Bank</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="{{ route('presti.tagihan.upload', $row->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body py-4">
                                        <div class="mb-3">
                                            <p class="text-muted small mb-2">Tagihan: <strong>{{ $row->nama_tagihan }}</strong></p>
                                            <p class="text-muted small mb-3">Total Nominal: <strong class="text-primary">Rp {{ number_format($row->nominal, 0, ',', '.') }}</strong></p>
                                            
                                            <label class="form-label fw-semibold">Pilih Gambar Bukti Transfer</label>
                                            <input type="file" name="bukti_transfer" class="form-control rounded-3" accept="image/*" required>
                                            <small class="text-muted mt-1 d-block">Format diperbolehkan: JPG, JPEG, PNG. Maksimal ukuran 2MB.</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 pt-0">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary px-4">Unggah Sekarang</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Tidak ada tagihan aktif.</td>
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
