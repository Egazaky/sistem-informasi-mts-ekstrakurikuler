@extends('admin/template')

@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Data Siswa</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Siswa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Tombol Aksi -->
        <div class="ms-auto text-end mt-3 d-flex gap-2 justify-content-end">
            <a href="{{ URL::route('tambah-siswa') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Tambah Data
            </a>
            <!-- Tombol Import Excel -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                <i class="fas fa-file-excel"></i> Import Excel
            </button>
        </div>
    </div>

    @if (isset($daftar_kelas) && $aksi == 'tampil')
    <!-- Pilihan Kelas -->
    <div class="card shadow-sm mb-3 mt-3">
        <div class="card-body">
            <h5 class="card-title mb-3">Pilih Kelas</h5>
            <div class="d-flex flex-wrap gap-2">
                @php $kelas_aktif = request('kelas', $daftar_kelas[0] ?? ''); @endphp
                @foreach ($daftar_kelas as $kls)
                    <a href="?kelas={{ $kls }}"
                       class="btn btn-sm rounded-pill
                              {{ $kelas_aktif == $kls ? 'btn-primary text-white' : 'btn-outline-primary' }}">
                        {{ $kls }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Wali Kelas -->
    <div class="card shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-1">Wali Kelas</h6>
                <span class="fw-bold text-primary" id="waliKelasTampil">
                    {{ $wali_kelas ?? '-' }}
                </span>
            </div>
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#waliKelasModal">
                <i class="fas fa-user-edit me-1"></i> Edit Wali Kelas
            </button>
        </div>
    </div>

    <!-- Modal Edit Wali Kelas -->
    <div class="modal fade" id="waliKelasModal" tabindex="-1" aria-labelledby="waliKelasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('update-wali-kelas') }}">
                @csrf
                <input type="hidden" name="kelas" value="{{ $kelas_aktif }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="waliKelasModalLabel">
                            Edit Wali Kelas <span class="text-primary">{{ $kelas_aktif }}</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label for="nama_wali" class="form-label">Nama Wali Kelas</label>
                        <input type="text" class="form-control" name="nama_wali" id="nama_wali"
                               value="{{ $wali_kelas ?? '' }}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <div class="container-fluid">
        @if ($aksi == 'tampil')
        <!-- Modal Import Excel -->
        <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('import-siswa') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importExcelModalLabel">
                                Import Data Siswa (Excel)
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group mb-3">
                                <label for="file" class="form-label">Pilih File Excel (.xlsx, .xls)</label>
                                <input type="file" name="file" class="form-control" id="file" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Import Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Siswa -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Tabel Siswa</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>KET</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; $kelas_aktif = isset($daftar_kelas) ? request('kelas', $daftar_kelas[0] ?? '') : ''; @endphp
                            @foreach (isset($daftar_kelas) ? $siswa->where('kelas', $kelas_aktif) : $siswa as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nama_siswa }}</td>
                                    <td>
                                        @if ($item->jen_kel == 'Laki-laki')
                                            L
                                        @elseif ($item->jen_kel == 'Perempuan')
                                            <span class="text-danger fst-italic">P</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->password }}</td>
                                    <td>
                                        @if ($item->status == '1')
                                            <span class="badge bg-success">Sudah</span>
                                        @else
                                            <span class="badge bg-danger">Belum</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('ubah-siswa', ['id' => $item->id]) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('hapus-siswa', ['id' => $item->id, 'kelas' => request('kelas', $kelas_aktif)]) }}"
                                           class="btn btn-outline-danger btn-sm"
                                           onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if ($aksi == 'ubah')
        <!-- Form Edit Siswa -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Form Edit</h5>
                <form method="post" action="{{ route('proses-ubah-siswa') }}?kelas={{ $kelas ?? '' }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $siswa[0]->id }}">
                    <div class="form-group row mb-3">
                        <label for="nama" class="col-sm-3 col-form-label text-end">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama" class="form-control" value="{{ $siswa[0]->nama_siswa }}" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="kelas" class="col-sm-3 col-form-label text-end">Kelas</label>
                        <div class="col-sm-9">
                            <input type="text" name="kelas" class="form-control" value="{{ $siswa[0]->kelas }}" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label text-end">Jenis Kelamin</label>
                        <div class="col-sm-9 d-flex gap-3">
                            <div class="form-check">
                                <input type="radio" name="jen_kel" value="Laki-laki" class="form-check-input" {{ $siswa[0]->jen_kel == 'Laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="jen_kel" value="Perempuan" class="form-check-input" {{ $siswa[0]->jen_kel == 'Perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label">Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body text-end">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                            <a href="{{ route('data-siswa', ['kelas' => $kelas ?? $siswa[0]->kelas]) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif

        @if ($aksi == 'tambah')
        <!-- Form Tambah Siswa -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Form Tambah</h5>
                <form method="post" action="{{ route('proses-tambah-siswa') }}?kelas={{ $kelas ?? '' }}">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="nama" class="col-sm-3 col-form-label text-end">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="kelas" class="col-sm-3 col-form-label text-end">Kelas</label>
                        <div class="col-sm-9">
                            <input type="text" name="kelas" class="form-control" value="{{ $siswa[0]->kelas }}" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label text-end">Jenis Kelamin</label>
                        <div class="col-sm-9 d-flex gap-3">
                            <div class="form-check">
                                <input type="radio" name="jen_kel" value="Laki-laki" class="form-check-input" required>
                                <label class="form-check-label">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="jen_kel" value="Perempuan" class="form-check-input" required>
                                <label class="form-check-label">Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body text-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('data-siswa', ['kelas' => $kelas ?? $daftar_kelas[0] ?? '']) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
