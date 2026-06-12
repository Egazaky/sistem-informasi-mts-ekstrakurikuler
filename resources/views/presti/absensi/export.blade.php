@extends('presti.layout')

@section('title', 'Export Laporan Absensi')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary mb-1">Export Laporan Absensi</h3>
    <p class="text-muted">Unduh rekapitulasi data absensi siswa dalam format Excel</p>
</div>

<div class="row g-4 mb-4">
    <!-- Rekap Harian -->
    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
            <h5 class="fw-bold text-primary mb-3">
                <i class="bi bi-calendar-day me-1"></i> Laporan Rekap Harian
            </h5>
            <form method="GET" action="{{ route('presti.absensi.export') }}">
                <input type="hidden" name="tipe" value="harian">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Kelas</label>
                    <select name="kelas" class="form-select rounded-3">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelas_list as $kls)
                            <option value="{{ $kls }}" {{ $kelas_id == $kls && $tipe == 'harian' ? 'selected' : '' }}>{{ $kls }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control rounded-3" value="{{ ($tipe == 'harian') ? $tanggal : date('Y-m-d') }}">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary fw-semibold px-3 rounded-3">
                        <i class="bi bi-eye me-1"></i> Preview
                    </button>
                    <a href="{{ route('presti.absensi.export') }}?export=harian&kelas={{ $kelas_id }}&tanggal={{ $tanggal }}&tipe=harian" class="btn btn-success fw-semibold px-3 rounded-3">
                        <i class="bi bi-file-earmark-excel me-1"></i> Download Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Rekap Bulanan -->
    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
            <h5 class="fw-bold text-success mb-3">
                <i class="bi bi-calendar-month me-1"></i> Laporan Bulanan (Matriks)
            </h5>
            <form method="GET" action="{{ route('presti.absensi.export') }}">
                <input type="hidden" name="tipe" value="bulanan">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Kelas</label>
                    <select name="kelas" class="form-select rounded-3">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelas_list as $kls)
                            <option value="{{ $kls }}" {{ $kelas_id == $kls && $tipe == 'bulanan' ? 'selected' : '' }}>{{ $kls }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-muted">Bulan</label>
                        <select name="bulan" class="form-select rounded-3">
                            @php
                                $nama_bulan_arr = [
                                    "01" => "Januari", "02" => "Februari", "03" => "Maret", 
                                    "04" => "April", "05" => "Mei", "06" => "Juni", 
                                    "07" => "Juli", "08" => "Agustus", "09" => "September", 
                                    "10" => "Oktober", "11" => "November", "12" => "Desember"
                                ];
                            @endphp
                            @foreach($nama_bulan_arr as $num => $name)
                                <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-muted">Tahun</label>
                        <input type="number" name="tahun" class="form-control rounded-3" value="{{ $tahun }}" min="2000" max="2100">
                    </div>
                </div>
                <div>
                    <a href="{{ route('presti.absensi.export') }}?export=bulanan&kelas={{ $kelas_id }}&bulan={{ $bulan }}&tahun={{ $tahun }}&tipe=bulanan" class="btn btn-success fw-semibold w-100 rounded-3">
                        <i class="bi bi-file-earmark-excel me-1"></i> Download Matriks Bulanan
                    </a>
                    <small class="text-muted d-block mt-2"><i class="bi bi-info-circle me-1"></i> Laporan bulanan matriks di-generate langsung dalam format spreadsheet.</small>
                </div>
            </form>
        </div>
    </div>
</div>

@if($tipe === 'harian' && isset($preview_data))
    <!-- Preview Harian -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <h5 class="fw-bold text-secondary mb-3"><i class="bi bi-list-check me-1"></i> Preview Laporan Harian ({{ date('d-m-Y', strtotime($tanggal)) }})</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($preview_data as $row)
                        @php
                            $badgeClass = 'bg-success';
                            if ($row->status === 'Terlambat') $badgeClass = 'bg-warning text-dark';
                            elseif ($row->status === 'Sakit' || $row->status === 'Izin') $badgeClass = 'bg-info';
                            elseif ($row->status === 'Alpha') $badgeClass = 'bg-danger';
                        @endphp
                        <tr>
                            <td class="fw-semibold text-muted">{{ $row->siswa->nis ?? '-' }}</td>
                            <td class="fw-bold text-dark">{{ $row->siswa->nama ?? '-' }}</td>
                            <td>{{ $row->siswa->kelas ?? '-' }}</td>
                            <td>{{ $row->jam_masuk ?: '-' }}</td>
                            <td>{{ $row->jam_pulang ?: '-' }}</td>
                            <td><span class="badge {{ $badgeClass }}">{{ $row->status }}</span></td>
                            <td>{{ $row->catatan ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">Tidak ada data absensi untuk kelas dan tanggal terpilih.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
