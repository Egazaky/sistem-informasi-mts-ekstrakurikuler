@extends('admin.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Data Pendaftaran Siswa</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Pendaftaran</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="ms-auto text-end" style="margin-top: 10px;">
            <a href="{{ route('admin.pendaftaran.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Tambah Data
            </a>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Pendaftaran</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Asal Sekolah</th>
                                        <th>No. HP</th>
                                        <th>Status</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pendaftarans as $index => $pendaftaran)
                                    <tr>
                                        <td>{{ $pendaftarans->firstItem() + $index }}</td>
                                        <td>{{ $pendaftaran->nama_lengkap }}</td>
                                        <td>{{ $pendaftaran->jenis_kelamin }}</td>
                                        <td>{{ $pendaftaran->asal_sekolah }}</td>
                                        <td>{{ $pendaftaran->no_hp }}</td>
                                        <td>
                                            @if($pendaftaran->status == 'pending')
                                                <span class="badge badge-warning">Menunggu</span>
                                            @elseif($pendaftaran->status == 'diterima')
                                                <span class="badge badge-success">Diterima</span>
                                            @else
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ $pendaftaran->tahun_ajaran }}</td>
                                        <td>{{ $pendaftaran->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.pendaftaran.show', $pendaftaran->id) }}"
                                               class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.pendaftaran.edit', $pendaftaran->id) }}"
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                    data-toggle="modal" data-target="#statusModal{{ $pendaftaran->id }}"
                                                    title="Update Status">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <form action="{{ route('admin.pendaftaran.destroy', $pendaftaran->id) }}"
                                                  method="POST" style="display: inline-block;"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Status Modal -->
                                    <div class="modal fade" id="statusModal{{ $pendaftaran->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Update Status Pendaftaran</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.pendaftaran.update-status', $pendaftaran->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status" required>
                                                                <option value="pending" {{ $pendaftaran->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                                                <option value="diterima" {{ $pendaftaran->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                                                <option value="ditolak" {{ $pendaftaran->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="catatan">Catatan</label>
                                                            <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ $pendaftaran->catatan }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data pendaftaran</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $pendaftarans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
