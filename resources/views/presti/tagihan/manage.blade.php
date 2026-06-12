@extends('presti.layout')

@section('title', 'Kelola Keuangan SPP')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-primary mb-0">Kelola Tagihan SPP</h3>
        <p class="text-muted mb-0">Manajemen tagihan keuangan syariah, gedung, daftar ulang, dan lainnya</p>
    </div>
    
    <button type="button" class="btn btn-primary fw-semibold px-4 rounded-3" data-bs-toggle="modal" data-bs-target="#createBillModal">
        <i class="bi bi-plus-lg me-1"></i> Buat Tagihan Baru
    </button>
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

<!-- Filters -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('presti.tagihan.manage') }}" class="row g-3">
            <div class="col-12 col-sm-6 col-md-3">
                <label class="form-label fw-semibold text-muted">Cari Nama Siswa</label>
                <input type="text" name="search_nama" class="form-control" placeholder="Nama siswa..." value="{{ $search_nama }}">
            </div>
            
            <div class="col-12 col-sm-6 col-md-2">
                <label class="form-label fw-semibold text-muted">Kelas</label>
                <select name="filter_kelas" class="form-select">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelas_list as $kls)
                        <option value="{{ $kls }}" {{ $filter_kelas == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-sm-6 col-md-2">
                <label class="form-label fw-semibold text-muted">Jenis</label>
                <select name="filter_jenis" class="form-select">
                    <option value="">-- Semua Jenis --</option>
                    <option value="Syariah" {{ $filter_jenis == 'Syariah' ? 'selected' : '' }}>Syariah</option>
                    <option value="Jariyah Gedung" {{ $filter_jenis == 'Jariyah Gedung' ? 'selected' : '' }}>Jariyah Gedung</option>
                    <option value="LKM dan Daftar Ulang" {{ $filter_jenis == 'LKM dan Daftar Ulang' ? 'selected' : '' }}>LKM & Daftar Ulang</option>
                    <option value="Lain-lain" {{ $filter_jenis == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                </select>
            </div>
            
            <div class="col-12 col-sm-6 col-md-2">
                <label class="form-label fw-semibold text-muted">Status</label>
                <select name="filter_status" class="form-select">
                    <option value="">-- Semua Status --</option>
                    <option value="Belum Bayar" {{ $filter_status == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="Menunggu Verifikasi" {{ $filter_status == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="Lunas" {{ $filter_status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>

            <div class="col-12 col-sm-6 col-md-2">
                <label class="form-label fw-semibold text-muted">Bulan Tenggat</label>
                <select name="filter_bulan" class="form-select">
                    <option value="">-- Semua Bulan --</option>
                    @php
                        $bulans = [
                            1=>"Januari", 2=>"Februari", 3=>"Maret", 4=>"April", 5=>"Mei", 6=>"Juni",
                            7=>"Juli", 8=>"Agustus", 9=>"September", 10=>"Oktober", 11=>"November", 12=>"Desember"
                        ];
                    @endphp
                    @foreach($bulans as $num => $nama)
                        <option value="{{ $num }}" {{ $filter_bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter"></i></button>
            </div>
        </form>
    </div>
</div>

<!-- Bills Table -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Siswa</th>
                        <th>Tagihan</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Tenggat</th>
                        <th>Bayar</th>
                        <th>Metode</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihan as $row)
                        @php
                            $badgeClass = 'bg-success';
                            if ($row->status === 'Belum Bayar') $badgeClass = 'bg-danger';
                            elseif ($row->status === 'Menunggu Verifikasi') $badgeClass = 'bg-warning text-dark';
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $row->siswa->nama ?? 'Siswa Terhapus' }}</div>
                                <div class="text-muted small">NIS: {{ $row->siswa->nis ?? '-' }} | {{ $row->siswa->kelas ?? '-' }}</div>
                            </td>
                            <td><span class="fw-semibold text-dark">{{ $row->nama_tagihan }}</span></td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $row->jenis_pembayaran }}</span></td>
                            <td class="fw-bold text-primary">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                            <td><span class="badge {{ $badgeClass }}">{{ $row->status }}</span></td>
                            <td>{{ date('d-m-Y', strtotime($row->tenggat_bayar)) }}</td>
                            <td>{{ $row->tanggal_bayar ? date('d-m-Y H:i', strtotime($row->tanggal_bayar)) : '-' }}</td>
                            <td>{{ $row->metode_bayar ?: '-' }}</td>
                            <td class="text-end pe-4">
                                @if($row->status === 'Menunggu Verifikasi')
                                    <!-- Verifikasi Bukti -->
                                    <button type="button" class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $row->id }}" title="Verifikasi Bukti Transfer">
                                        <i class="bi bi-file-earmark-image"></i>
                                    </button>
                                @elseif($row->status === 'Belum Bayar')
                                    <!-- Bayar Cash -->
                                    <form action="{{ route('presti.tagihan.cash', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin melunasi tagihan ini secara Cash?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success me-1" title="Bayar Cash">
                                            <i class="bi bi-cash-stack"></i>
                                        </button>
                                    </form>
                                @endif

                                <!-- Edit & Delete -->
                                <button type="button" class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editBillModal{{ $row->id }}" title="Edit Tagihan">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('presti.tagihan.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Tagihan">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Verify Modal -->
                        @if($row->status === 'Menunggu Verifikasi')
                            <div class="modal fade" id="verifyModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0">
                                        <div class="modal-header border-bottom-0 pb-0">
                                            <h5 class="modal-title fw-bold text-primary">Verifikasi Bukti Pembayaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center py-4">
                                            <p class="text-muted small">Wali Murid dari <strong>{{ $row->siswa->nama ?? '-' }}</strong> mengunggah bukti bayar berikut:</p>
                                            <div class="border rounded-3 overflow-hidden p-2 mb-3 bg-light d-flex justify-content-center">
                                                @if($row->bukti_bayar)
                                                    <img src="{{ asset('uploads/' . $row->bukti_bayar) }}" class="img-fluid" style="max-height: 350px; object-fit: contain;" alt="Bukti Transfer">
                                                @else
                                                    <span class="text-danger small">Bukti transfer tidak ditemukan.</span>
                                                @endif
                                            </div>
                                            <h6 class="fw-bold">Total Pembayaran: <span class="text-primary">Rp {{ number_format($row->nominal, 0, ',', '.') }}</span></h6>
                                        </div>
                                        <div class="modal-footer border-top-0 pt-0 justify-content-between">
                                            <form action="{{ route('presti.tagihan.tolak', $row->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger px-3 rounded-3">Tolak Bukti</button>
                                            </form>
                                            <form action="{{ route('presti.tagihan.setuju', $row->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success px-4 rounded-3">Setujui / Lunas</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Edit Bill Modal -->
                        <div class="modal fade" id="editBillModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold text-primary">Edit Tagihan SPP</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('presti.tagihan.update', $row->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body py-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nama / Judul Tagihan</label>
                                                <input type="text" name="nama_tagihan" class="form-control rounded-3" value="{{ $row->nama_tagihan }}" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Jenis Pembayaran</label>
                                                <select name="jenis_pembayaran" class="form-select rounded-3" required>
                                                    <option value="Syariah" {{ $row->jenis_pembayaran == 'Syariah' ? 'selected' : '' }}>Syariah</option>
                                                    <option value="Jariyah Gedung" {{ $row->jenis_pembayaran == 'Jariyah Gedung' ? 'selected' : '' }}>Jariyah Gedung</option>
                                                    <option value="LKM dan Daftar Ulang" {{ $row->jenis_pembayaran == 'LKM dan Daftar Ulang' ? 'selected' : '' }}>LKM & Daftar Ulang</option>
                                                    <option value="Lain-lain" {{ $row->jenis_pembayaran == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                                </select>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nominal (Rp)</label>
                                                <input type="number" name="nominal" class="form-control rounded-3" value="{{ $row->nominal }}" required min="1">
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Tenggat Pembayaran</label>
                                                <input type="date" name="tenggat_bayar" class="form-control rounded-3" value="{{ $row->tenggat_bayar }}" required>
                                            </div>
                                            
                                            <div class="mb-0">
                                                <label class="form-label fw-semibold">Status Tagihan</label>
                                                <select name="status" class="form-select rounded-3" required>
                                                    <option value="Belum Bayar" {{ $row->status == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                                                    <option value="Menunggu Verifikasi" {{ $row->status == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                                    <option value="Lunas" {{ $row->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                                </select>
                                                <small class="text-muted mt-1 d-block">Mengubah status ke 'Belum Bayar' otomatis akan menghapus bukti transfer jika ada.</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 pt-0">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">Data tagihan tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Bill Modal -->
<div class="modal fade" id="createBillModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-primary">Buat Tagihan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('presti.tagihan.store') }}">
                @csrf
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama / Judul Tagihan</label>
                        <input type="text" name="nama_tagihan" class="form-control rounded-3" placeholder="Contoh: Syariah Bulan Juli 2026" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Pembayaran</label>
                        <select name="jenis_pembayaran" class="form-select rounded-3" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Syariah">Syariah</option>
                            <option value="Jariyah Gedung">Jariyah Gedung</option>
                            <option value="LKM dan Daftar Ulang">LKM & Daftar Ulang</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nominal Tagihan (Rp)</label>
                        <input type="number" name="nominal" class="form-control rounded-3" placeholder="Contoh: 150000" required min="1">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tenggat Pembayaran</label>
                        <input type="date" name="tenggat_bayar" class="form-control rounded-3" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Target Penerima Tagihan</label>
                        <select name="target_tipe" id="targetTipe" class="form-select rounded-3" required onchange="handleTargetTipe(this.value)">
                            <option value="semua">Semua Siswa</option>
                            <option value="kelas">Per Kelas</option>
                            <option value="siswa">Siswa Tertentu</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="targetKelasGroup">
                        <label class="form-label fw-semibold">Pilih Kelas</label>
                        <select name="target_kelas" class="form-select rounded-3">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas_list as $kls)
                                <option value="{{ $kls }}">{{ $kls }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-0 d-none" id="targetSiswaGroup">
                        <label class="form-label fw-semibold">Pilih Siswa</label>
                        <select name="target_siswa" class="form-select rounded-3" style="width: 100%;">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswa_list as $sw)
                                <option value="{{ $sw->id }}">{{ $sw->nama }} (NIS: {{ $sw->nis }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Buat Tagihan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleTargetTipe(value) {
        const kelasGroup = document.getElementById('targetKelasGroup');
        const siswaGroup = document.getElementById('targetSiswaGroup');
        
        kelasGroup.classList.add('d-none');
        siswaGroup.classList.add('d-none');
        
        if (value === 'kelas') {
            kelasGroup.classList.remove('d-none');
        } else if (value === 'siswa') {
            siswaGroup.classList.remove('d-none');
        }
    }
</script>
@endsection
