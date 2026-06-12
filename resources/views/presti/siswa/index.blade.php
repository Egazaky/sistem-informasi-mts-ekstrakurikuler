@extends('presti.layout')

@section('title', 'Kelola Siswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-primary mb-0">Kelola Siswa</h3>
        <p class="text-muted mb-0">Manajemen data siswa dan akun orang tua</p>
    </div>
    
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="bi bi-file-earmark-arrow-up me-1"></i> Import CSV
        </button>
        <button type="button" class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah Siswa
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Filter Kelas -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('presti.siswa.index') }}" class="row g-3 align-items-center">
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold text-muted">Filter Kelas</label>
                <select name="filter_kelas" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelas_list as $kls)
                        <option value="{{ $kls }}" {{ $filter_kelas == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                    @endforeach
                </select>
            </div>
            @if($filter_kelas)
                <div class="col-12 col-md-2 mt-md-4 pt-md-2">
                    <a href="{{ route('presti.siswa.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Table Siswa -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>No HP Orang Tua</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $row)
                        <tr>
                            <td class="ps-4 fw-semibold text-muted">{{ $row->nis }}</td>
                            <td class="fw-bold text-dark">{{ $row->nama }}</td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $row->kelas }}</span></td>
                            <td>{{ $row->no_hp_ortu ?: '-' }}</td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-outline-warning me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal{{ $row->id }}"
                                    title="Edit Siswa">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('presti.siswa.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini? Semua riwayat absensi, tagihan, dan akun orang tua juga akan dihapus!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Siswa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold text-primary">Edit Data Siswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('presti.siswa.update', $row->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body py-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">NIS</label>
                                                <input type="text" name="nis" class="form-control rounded-3" value="{{ $row->nis }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                                <input type="text" name="nama" class="form-control rounded-3" value="{{ $row->nama }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Kelas</label>
                                                <input type="text" name="kelas" class="form-control rounded-3" value="{{ $row->kelas }}" required>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-semibold">No HP Orang Tua</label>
                                                <input type="text" name="no_hp_ortu" class="form-control rounded-3" value="{{ $row->no_hp_ortu }}" placeholder="Contoh: 62812345678">
                                                <small class="text-muted mt-1 d-block">Akun ortu otomatis dibuat/diupdate apabila No HP diisi.</small>
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
                            <td colspan="5" class="text-center py-4 text-muted">Data siswa tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-primary">Tambah Siswa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('presti.siswa.store') }}">
                @csrf
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">NIS</label>
                        <input type="text" name="nis" class="form-control rounded-3" required placeholder="Contoh: 24230004">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control rounded-3" required placeholder="Nama lengkap siswa">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kelas</label>
                        <input type="text" name="kelas" class="form-control rounded-3" required placeholder="Contoh: 9A atau X RPL 1">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">No HP Orang Tua</label>
                        <input type="text" name="no_hp_ortu" class="form-control rounded-3" placeholder="Contoh: 62812345678">
                        <small class="text-muted mt-1 d-block">Akun ortu otomatis dibuat apabila No HP diisi.</small>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Tambah Siswa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import CSV Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-primary">Import Data Siswa dari CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('presti.siswa.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body py-4">
                    <div class="alert alert-info small rounded-3 mb-3">
                        <i class="bi bi-info-circle me-1"></i> Format file harus CSV. Unduh template di bawah sebagai pedoman penataan kolom data.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih File CSV</label>
                        <input type="file" name="file_csv" class="form-control rounded-3" accept=".csv" required>
                    </div>
                    
                    <a href="{{ route('presti.siswa.template') }}" class="btn btn-sm btn-outline-secondary text-decoration-none">
                        <i class="bi bi-download me-1"></i> Unduh Template CSV
                    </a>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Mulai Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
