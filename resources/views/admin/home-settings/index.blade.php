@extends('admin.template')
@section('content')
<div class="page-wrapper">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-12">
                <h4 class="page-title">Pengaturan Beranda</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Pengaturan Beranda
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Container -->
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <!-- Card Header -->
            <div class="card-header text-white" style="background-color:#7e3ff2!important;">
                <h4 class="mb-0">
                    <i class="mdi mdi-home me-2"></i> Pengaturan Halaman Beranda
                </h4>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.home-settings.update') }}" method="POST">
                    @csrf

                    <!-- Informasi Umum -->
                    <h5 class="text-primary mt-3 mb-3">
                        <i class="fas fa-cogs me-2"></i> Informasi Umum
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Judul Utama</label>
                            <input type="text" name="judul_utama" class="form-control" value="{{ old('judul_utama', $setting->judul_utama) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Subjudul Utama</label>
                            <input type="text" name="subjudul_utama" class="form-control" value="{{ old('subjudul_utama', $setting->subjudul_utama) }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Mengapa Pilih Kami?</label>
                            <textarea name="mengapa_pilih_kami" class="form-control" rows="3">{{ old('mengapa_pilih_kami', $setting->mengapa_pilih_kami) }}</textarea>
                        </div>
                    </div>

                    <!-- Akreditasi -->
                    <h5 class="text-primary mt-4 mb-3">
                        <i class="fas fa-certificate me-2"></i> Akreditasi
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Akreditasi</label>
                            <input type="text" name="akreditasi" class="form-control" value="{{ old('akreditasi', $setting->akreditasi) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Deskripsi Akreditasi</label>
                            <textarea name="deskripsi_akreditasi" class="form-control" rows="3">{{ old('deskripsi_akreditasi', $setting->deskripsi_akreditasi) }}</textarea>
                        </div>
                    </div>

                    <!-- Fasilitas & Alumni -->
                    <h5 class="text-primary mt-4 mb-3">
                        <i class="fas fa-school me-2"></i> Fasilitas & Alumni
                    </h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Fasilitas <span class="text-muted">(pisahkan dengan koma)</span></label>
                        <input type="text" name="fasilitas" class="form-control" value="{{ old('fasilitas', $setting->fasilitas) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alumni Sukses</label>
                        <textarea name="alumni_sukses" class="form-control" rows="3">{{ old('alumni_sukses', $setting->alumni_sukses) }}</textarea>
                    </div>

                    <!-- Sambutan Kepala Sekolah -->
                    <h5 class="text-primary mt-4 mb-3">
                        <i class="fas fa-user-tie me-2"></i> Sambutan Kepala Sekolah
                    </h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sambutan Kepala Sekolah</label>
                        <textarea name="sambutan_kepala_sekolah" class="form-control" rows="3">{{ old('sambutan_kepala_sekolah', $setting->sambutan_kepala_sekolah) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Kepala Sekolah <span class="text-muted">(URL)</span></label>
                        <input type="text" name="foto_kepala_sekolah" class="form-control" value="{{ old('foto_kepala_sekolah', $setting->foto_kepala_sekolah) }}">
                    </div>

                    <!-- Kontak & Lokasi -->
                    <h5 class="text-primary mt-4 mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i> Kontak & Lokasi
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $setting->alamat) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $setting->telepon) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $setting->email) }}">
                    </div>

                    <!-- Footer -->
                    <h5 class="text-primary mt-4 mb-3">
                        <i class="fas fa-info-circle me-2"></i> Footer
                    </h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Footer</label>
                        <input type="text" name="footer" class="form-control" value="{{ old('footer', $setting->footer) }}">
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
