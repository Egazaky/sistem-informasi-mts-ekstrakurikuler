@extends('admin.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Data Berita</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Berita</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="ms-auto text-end" style="margin-top: 10px;">
            <a href="{{ route('berita.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> tambah data
            </a>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Berita</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Isi</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($berita as $key => $item)
                                    <tr>
                                        <td class="align-middle">{{ $berita->firstItem() + $key }}</td>
                                        <td class="align-middle">
                                            <h6 class="mb-1">{{ $item->title }}</h6>
                                            <small class="text-muted">
                                                <i class="far fa-clock"></i>
                                                {{ $item->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
                                            </small>
                                        </td>
                                        <td class="align-middle">{{ Str::limit(strip_tags($item->content), 100) }}</td>
                                        <td class="align-middle text-center">
                                            @if($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}"
                                                     alt="{{ $item->title }}"
                                                     class="img-thumbnail"
                                                     style="max-width: 100px; height: auto;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('berita.edit', $item->id) }}"
                                                   class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('berita.destroy', $item->id) }}"
                                                      method="POST"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <img src="{{ asset('img/no-data.svg') }}" alt="No Data" style="width: 100px; margin-bottom: 1rem;">
                                            <p class="text-muted mb-0">Belum ada berita yang ditambahkan</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $berita->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
