@extends('admin.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Detail Pendaftaran - {{ $pendaftaran->nama_lengkap }}</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.pendaftaran.index') }}">Data Pendaftaran</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
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
                        <h3 class="card-title">Detail Pendaftaran</h3>
                    </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Data Pribadi</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Nama Lengkap:</strong></td>
                                    <td>{{ $pendaftaran->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Panggilan:</strong></td>
                                    <td>{{ $pendaftaran->nama_panggilan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tempat, Tanggal Lahir:</strong></td>
                                    <td>{{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Kelamin:</strong></td>
                                    <td>{{ $pendaftaran->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Agama:</strong></td>
                                    <td>{{ $pendaftaran->agama }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat:</strong></td>
                                    <td>{{ $pendaftaran->alamat }}</td>
                                </tr>
                                <tr>
                                    <td><strong>No. HP:</strong></td>
                                    <td>{{ $pendaftaran->no_hp }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $pendaftaran->email ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Data Orang Tua</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Nama Ayah:</strong></td>
                                    <td>{{ $pendaftaran->nama_ayah }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pekerjaan Ayah:</strong></td>
                                    <td>{{ $pendaftaran->pekerjaan_ayah ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Ibu:</strong></td>
                                    <td>{{ $pendaftaran->nama_ibu }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pekerjaan Ibu:</strong></td>
                                    <td>{{ $pendaftaran->pekerjaan_ibu ?? '-' }}</td>
                                </tr>
                            </table>

                            <h5>Data Sekolah</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Asal Sekolah:</strong></td>
                                    <td>{{ $pendaftaran->asal_sekolah }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun Ajaran:</strong></td>
                                    <td>{{ $pendaftaran->tahun_ajaran }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($pendaftaran->status == 'pending')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($pendaftaran->status == 'diterima')
                                            <span class="badge badge-success">Diterima</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Daftar:</strong></td>
                                    <td>{{ $pendaftaran->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                @if($pendaftaran->catatan)
                                <tr>
                                    <td><strong>Catatan:</strong></td>
                                    <td>{{ $pendaftaran->catatan }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($pendaftaran->dokumen_path)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Dokumen Pendaftaran</h5>
                            <div class="alert alert-info">
                                <i class="fas fa-file-archive"></i>
                                <strong>Dokumen:</strong>
                                <a href="{{ asset('storage/dokumen_pendaftaran/' . $pendaftaran->dokumen_path) }}"
                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Update Status</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.pendaftaran.update-status', $pendaftaran->id) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" id="status" name="status" required>
                                                        <option value="pending" {{ $pendaftaran->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                                        <option value="diterima" {{ $pendaftaran->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                                        <option value="ditolak" {{ $pendaftaran->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="catatan">Catatan</label>
                                                    <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Masukkan catatan jika ada">{{ $pendaftaran->catatan }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Status
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
