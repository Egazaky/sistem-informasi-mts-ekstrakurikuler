@extends('admin.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Data Galeri</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Galeri</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="ms-auto text-end" style="margin-top: 10px;">
            <a href="{{ route('gallery.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> tambah gambar
            </a>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengaturan Tentang Kami & Galeri</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- Form Tentang Kami (sinkron dengan landing /tentang-kami) --}}
                        <form action="{{ route('gallery.update-about') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="about_title">Judul Tentang Kami</label>
                                        <input type="text" name="about_title" id="about_title" class="form-control @error('about_title') is-invalid @enderror" value="{{ old('about_title', $profile->about_title) }}" placeholder="Misal: Tentang MTS Al Islam">
                                        @error('about_title')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="about_description">Deskripsi Tentang Kami</label>
                                        <textarea name="about_description" id="about_description" rows="5" class="form-control @error('about_description') is-invalid @enderror" placeholder="Tuliskan deskripsi singkat mengenai sekolah...">{{ old('about_description', $profile->about_description) }}</textarea>
                                        @error('about_description')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="about_image">Gambar Tentang Kami</label>
                                        <input type="file" name="about_image" id="about_image" class="form-control @error('about_image') is-invalid @enderror" accept="image/*">
                                        <small class="form-text text-muted">Opsional. Format: JPG, PNG, GIF, SVG. Maks 20MB.</small>
                                        @error('about_image')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @if(!empty($profile->about_image))
                                        <div class="mb-3">
                                            <label>Preview Gambar Saat Ini:</label>
                                            <div>
                                                <img src="{{ asset('storage/' . $profile->about_image) }}" alt="About image" style="max-width: 100%; height: auto;">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end mb-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan Tentang Kami
                                </button>
                            </div>
                        </form>

                        <hr>

                        <h4 class="mb-3">Tabel Galeri</h4>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Caption</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($galleries as $key => $item)
                                    <tr>
                                        <td>{{ $galleries->firstItem() + $key }}</td>
                                        <td>
                                            @if($item->image_path)
                                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->caption }}" width="100">
                                            @endif
                                        </td>
                                        <td>{{ $item->caption }}</td>
                                        <td>
                                            <a href="{{ route('gallery.edit', $item->id) }}" class="btn btn-sm btn-info">Edit</a>
                                            <form action="{{ route('gallery.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $galleries->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection