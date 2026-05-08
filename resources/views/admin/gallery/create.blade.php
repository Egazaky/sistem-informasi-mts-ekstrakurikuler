@extends('admin.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Tambah Gambar Galeri</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Gambar Galeri</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Gambar Galeri</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group mb-4">
                                <label for="image" class="form-label">Upload Gambar <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="image"
                                           class="form-control @error('image') is-invalid @enderror"
                                           id="image" required accept="image/*"
                                           onchange="previewImage(this);">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="imagePreview" class="mt-3 text-center d-none">
                                    <img src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                                </div>
                                <small class="text-muted">Format: JPG, JPEG, PNG, GIF (Max. 20MB)</small>
                            </div>

                            <div class="form-group mb-4">
                                <label for="caption" class="form-label">Caption</label>
                                <textarea name="caption" class="form-control @error('caption') is-invalid @enderror"
                                    id="caption" rows="3" placeholder="Deskripsi singkat tentang gambar">{{ old('caption') }}</textarea>
                                @error('caption')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('gallery.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Gambar
                                </button>
                            </div>

                            @push('scripts')
                            <script>
                            function previewImage(input) {
                                const preview = document.getElementById('imagePreview');
                                const image = preview.querySelector('img');

                                if (input.files && input.files[0]) {
                                    const reader = new FileReader();

                                    reader.onload = function(e) {
                                        image.src = e.target.result;
                                        preview.classList.remove('d-none');
                                    }

                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                            </script>
                            @endpush
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
