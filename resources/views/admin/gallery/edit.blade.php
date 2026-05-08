@extends('admin.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit Gambar Galeri</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Gambar Galeri</li>
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
                        <h3 class="card-title">Form Edit Gambar Galeri</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="image">Gambar Saat Ini</label>
                                @if($gallery->image_path)
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->caption }}" width="200" class="mt-2">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="caption">Caption (Opsional)</label>
                                <input type="text" name="caption" class="form-control" id="caption" value="{{ $gallery->caption }}" placeholder="Masukkan Caption">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection