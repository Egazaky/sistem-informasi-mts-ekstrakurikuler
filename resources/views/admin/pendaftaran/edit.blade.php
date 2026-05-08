@extends('admin.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit Data Pendaftaran - {{ $pendaftaran->nama_lengkap }}</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.pendaftaran.index') }}">Data Pendaftaran</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="ms-auto text-end" style="margin-top: 10px;">
            <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Data Pendaftaran</h3>
                    </div>
                <div class="card-body">
                    <form action="{{ route('admin.pendaftaran.update', $pendaftaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <h5>Data Pribadi</h5>
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                           value="{{ old('nama_lengkap', $pendaftaran->nama_lengkap) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama_panggilan">Nama Panggilan</label>
                                    <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan"
                                           value="{{ old('nama_panggilan', $pendaftaran->nama_panggilan) }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                                   value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                                   value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir->format('Y-m-d')) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L" {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="agama">Agama <span class="text-danger">*</span></label>
                                            <select class="form-control" id="agama" name="agama" required>
                                                <option value="">Pilih Agama</option>
                                                <option value="Islam" {{ old('agama', $pendaftaran->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                <option value="Kristen" {{ old('agama', $pendaftaran->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                                <option value="Katolik" {{ old('agama', $pendaftaran->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                                <option value="Hindu" {{ old('agama', $pendaftaran->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                <option value="Buddha" {{ old('agama', $pendaftaran->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                                <option value="Konghucu" {{ old('agama', $pendaftaran->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $pendaftaran->alamat) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_hp">No. HP/WhatsApp <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="no_hp" name="no_hp"
                                                   value="{{ old('no_hp', $pendaftaran->no_hp) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   value="{{ old('email', $pendaftaran->email) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>Data Orang Tua</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_ayah">Nama Ayah <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nama_ayah" name="nama_ayah"
                                                   value="{{ old('nama_ayah', $pendaftaran->nama_ayah) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                                            <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah"
                                                   value="{{ old('pekerjaan_ayah', $pendaftaran->pekerjaan_ayah) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_ibu">Nama Ibu <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nama_ibu" name="nama_ibu"
                                                   value="{{ old('nama_ibu', $pendaftaran->nama_ibu) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                            <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu"
                                                   value="{{ old('pekerjaan_ibu', $pendaftaran->pekerjaan_ibu) }}">
                                        </div>
                                    </div>
                                </div>

                                <h5>Data Sekolah</h5>
                                <div class="form-group">
                                    <label for="asal_sekolah">Asal Sekolah <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah"
                                           value="{{ old('asal_sekolah', $pendaftaran->asal_sekolah) }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tahun_ajaran">Tahun Ajaran <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran"
                                                   value="{{ old('tahun_ajaran', $pendaftaran->tahun_ajaran) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="pending" {{ old('status', $pendaftaran->status) == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="diterima" {{ old('status', $pendaftaran->status) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                                <option value="ditolak" {{ old('status', $pendaftaran->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="catatan">Catatan</label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                              placeholder="Masukkan catatan jika ada">{{ old('catatan', $pendaftaran->catatan) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
