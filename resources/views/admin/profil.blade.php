@extends('admin.template')
@section('content')

<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Profil</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profil</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">
                        Pengaturan Profil Landing Page
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
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

                            @csrf

                            <!-- Kepala Sekolah Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Data Kepala Sekolah</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-3">
                                            @if($profile->kepala_sekolah_foto)
                                            <div class="current-photo mb-3">
                                                <img src="{{ asset('storage/' . $profile->kepala_sekolah_foto) }}" 
                                                     class="img-thumbnail" alt="Foto Kepala Sekolah"
                                                     style="max-width: 150px;">
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label for="kepala_sekolah_foto" class="form-label">Foto Kepala Sekolah</label>
                                                <input type="file" class="form-control @error('kepala_sekolah_foto') is-invalid @enderror" 
                                                       name="kepala_sekolah_foto" id="kepala_sekolah_foto" accept="image/*">
                                                @error('kepala_sekolah_foto')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Format: JPG, PNG (Maks. 20MB)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kepala_sekolah_nama" class="form-label">Nama Kepala Sekolah</label>
                                        <input type="text" class="form-control @error('kepala_sekolah_nama') is-invalid @enderror" 
                                               name="kepala_sekolah_nama" id="kepala_sekolah_nama" 
                                               value="{{ old('kepala_sekolah_nama', $profile->kepala_sekolah_nama) }}"
                                               placeholder="Masukkan nama lengkap kepala sekolah">
                                        @error('kepala_sekolah_nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="kepala_sekolah_sambutan" class="form-label">Sambutan Kepala Sekolah</label>
                                        <textarea class="form-control @error('kepala_sekolah_sambutan') is-invalid @enderror" 
                                                  name="kepala_sekolah_sambutan" id="kepala_sekolah_sambutan" 
                                                  rows="6" placeholder="Masukkan sambutan kepala sekolah">{{ old('kepala_sekolah_sambutan', $profile->kepala_sekolah_sambutan) }}</textarea>
                                        @error('kepala_sekolah_sambutan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Masukkan sambutan atau pesan dari kepala sekolah untuk ditampilkan di halaman utama</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Hero Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Hero Section</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="hero_title" class="form-label">Hero Title</label>
                                        <input type="text" class="form-control @error('hero_title') is-invalid @enderror"
                                               name="hero_title" id="hero_title"
                                               value="{{ old('hero_title', $profile->hero_title) }}">
                                        @error('hero_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="hero_subtitle" class="form-label">Hero Subtitle</label>
                                        <textarea class="form-control @error('hero_subtitle') is-invalid @enderror"
                                                  name="hero_subtitle" id="hero_subtitle"
                                                  rows="3">{{ old('hero_subtitle', $profile->hero_subtitle) }}</textarea>
                                        @error('hero_subtitle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="tagline" class="form-label">Tagline</label>
                                        <input type="text" class="form-control @error('tagline') is-invalid @enderror"
                                               name="tagline" id="tagline"
                                               value="{{ old('tagline', $profile->tagline) }}">
                                        @error('tagline')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="whatsapp_link" class="form-label">WhatsApp Link (Full URL)</label>
                                        <input type="text" class="form-control @error('whatsapp_link') is-invalid @enderror"
                                               name="whatsapp_link" id="whatsapp_link"
                                               value="{{ old('whatsapp_link', $profile->whatsapp_link) }}">
                                        @error('whatsapp_link')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Contoh: https://wa.me/628123456789</small>
                                    </div>
                            </div>
                            <div class="mb-3">
                                <label for="whatsapp_number" class="form-label">WhatsApp Number (e.g., 081234567890)</label>
                                <input type="text" class="form-control @error('whatsapp_number') is-invalid @enderror"
                                       name="whatsapp_number" id="whatsapp_number"
                                       value="{{ old('whatsapp_number', $profile->whatsapp_number) }}"
                                       placeholder="Contoh: 081234567890">
                                @error('whatsapp_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                            <!-- About Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">About Section</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="about_title" class="form-label">About Title</label>
                                        <input type="text" class="form-control @error('about_title') is-invalid @enderror"
                                               name="about_title" id="about_title"
                                               value="{{ old('about_title', $profile->about_title) }}">
                                        @error('about_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="about_description" class="form-label">About Description</label>
                                        <textarea class="form-control @error('about_description') is-invalid @enderror"
                                                  name="about_description" id="about_description"
                                                  rows="4">{{ old('about_description', $profile->about_description) }}</textarea>
                                        @error('about_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-3">
                                            @if($profile->about_image)
                                            <div class="current-photo mb-3">
                                                <img src="{{ asset('storage/' . $profile->about_image) }}"
                                                     class="img-thumbnail" alt="About Image"
                                                     style="max-width: 150px;">
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label for="about_image" class="form-label">About Image</label>
                                                <input type="file" class="form-control @error('about_image') is-invalid @enderror"
                                                       name="about_image" id="about_image" accept="image/*">
                                                @error('about_image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Format: JPG, PNG (Maks. 20MB)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Registration Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Pendaftaran</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-3">
                                            @if($profile->registration_barcode)
                                            <div class="current-photo mb-3">
                                                <img src="{{ asset('storage/' . $profile->registration_barcode) }}"
                                                     class="img-thumbnail" alt="Barcode Pendaftaran"
                                                     style="max-width: 150px;">
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label for="registration_barcode" class="form-label">Barcode Pendaftaran</label>
                                                <input type="file" class="form-control @error('registration_barcode') is-invalid @enderror"
                                                       name="registration_barcode" id="registration_barcode" accept="image/*">
                                                @error('registration_barcode')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Format: JPG, PNG (Maks. 20MB)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Maps Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Lokasi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="google_maps_link" class="form-label">Google Maps Embed Link</label>
                                        <textarea class="form-control @error('google_maps_link') is-invalid @enderror"
                                                  name="google_maps_link" id="google_maps_link"
                                                  rows="3" placeholder="Masukkan link embed Google Maps">{{ old('google_maps_link', $profile->google_maps_link) }}</textarea>
                                        @error('google_maps_link')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Masukkan HTML iframe dari Google Maps</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i> Simpan Semua Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
