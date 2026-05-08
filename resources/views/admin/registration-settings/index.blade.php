@extends('admin/template')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Pengaturan Halaman Pendaftaran</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pengaturan Pendaftaran</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="mdi mdi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="mdi mdi-alert-circle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.registration-settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Hero Section -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="mdi mdi-star me-2"></i>Hero Section</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="hero_title" class="form-label">Judul Utama</label>
                            <input type="text" class="form-control" id="hero_title" name="hero_title" value="{{ $setting->hero_title }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hero_subtitle" class="form-label">Sub Judul</label>
                            <input type="text" class="form-control" id="hero_subtitle" name="hero_subtitle" value="{{ $setting->hero_subtitle }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="hero_year" class="form-label">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="hero_year" name="hero_year" value="{{ $setting->hero_year }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hero_badge" class="form-label">Badge Text</label>
                            <input type="text" class="form-control" id="hero_badge" name="hero_badge" value="{{ $setting->hero_badge }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Syarat Pendaftaran -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="mdi mdi-clipboard-list me-2"></i>Syarat Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div id="requirements-container">
                        @foreach(($setting->syarat_pendaftaran ?? []) as $index => $requirement)
                        <div class="requirement-item mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="requirements[]" value="{{ $requirement }}" required>
                                <button type="button" class="btn btn-danger remove-requirement" onclick="removeRequirement(this)">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success mb-3" onclick="addRequirement()">
                        <i class="mdi mdi-plus me-2"></i>Tambah Syarat
                    </button>
                    <div class="mb-3">
                        <label for="requirements_note" class="form-label">Catatan Syarat</label>
                        <input type="text" class="form-control" id="requirements_note" name="requirements_note" value="{{ $setting->requirements_note }}" required>
                    </div>
                </div>
            </div>

            <!-- Info Pendaftaran -->
            <div class="card mt-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="mdi mdi-information me-2"></i>Info Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="registration_info" class="form-label">Informasi Pendaftaran</label>
                        <textarea class="form-control" id="registration_info" name="registration_info" rows="3" required>{{ $setting->registration_info }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="wave1_title" class="form-label">Judul Gelombang 1</label>
                            <input type="text" class="form-control" id="wave1_title" name="wave1_title" value="{{ $setting->wave1_title }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="wave1_date" class="form-label">Tanggal Gelombang 1</label>
                            <input type="text" class="form-control" id="wave1_date" name="wave1_date" value="{{ $setting->wave1_date }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="wave2_title" class="form-label">Judul Gelombang 2</label>
                            <input type="text" class="form-control" id="wave2_title" name="wave2_title" value="{{ $setting->wave2_title }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="wave2_date" class="form-label">Tanggal Gelombang 2</label>
                            <input type="text" class="form-control" id="wave2_date" name="wave2_date" value="{{ $setting->wave2_date }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="location_name" class="form-label">Nama Tempat</label>
                            <input type="text" class="form-control" id="location_name" name="location_name" value="{{ $setting->location_name }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="location_address" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="location_address" name="location_address" value="{{ $setting->location_address }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="location_note" class="form-label">Catatan Lokasi</label>
                            <input type="text" class="form-control" id="location_note" name="location_note" value="{{ $setting->location_note }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program Unggulan -->
            <div class="card mt-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="mdi mdi-trophy me-2"></i>Program Unggulan</h5>
                </div>
                <div class="card-body">
                    <div id="programs-container">
                        @foreach(($setting->program_unggulan ?? []) as $index => $program)
                        <div class="program-item border p-3 mb-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Judul Program</label>
                                    <input type="text" class="form-control" name="featured_programs[{{ $index }}][title]" value="{{ $program['title'] }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" name="featured_programs[{{ $index }}][icon]" value="{{ $program['icon'] }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Warna</label>
                                    <select class="form-control" name="featured_programs[{{ $index }}][color]" required>
                                        <option value="primary" {{ $program['color'] == 'primary' ? 'selected' : '' }}>Primary</option>
                                        <option value="success" {{ $program['color'] == 'success' ? 'selected' : '' }}>Success</option>
                                        <option value="info" {{ $program['color'] == 'info' ? 'selected' : '' }}>Info</option>
                                        <option value="warning" {{ $program['color'] == 'warning' ? 'selected' : '' }}>Warning</option>
                                        <option value="danger" {{ $program['color'] == 'danger' ? 'selected' : '' }}>Danger</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="featured_programs[{{ $index }}][description]" rows="3" required>{{ $program['description'] }}</textarea>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeProgram(this)">
                                <i class="mdi mdi-delete me-1"></i>Hapus Program
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success" onclick="addProgram()">
                        <i class="mdi mdi-plus me-2"></i>Tambah Program
                    </button>
                </div>
            </div>

            <!-- Aspek Strategis -->
            <div class="card mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="mdi mdi-target me-2"></i>Aspek Strategis</h5>
                </div>
                <div class="card-body">
                    <div id="aspects-container">
                        @foreach(($setting->aspek_strategis ?? []) as $index => $aspect)
                        <div class="aspect-item border p-3 mb-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Judul Aspek</label>
                                    <input type="text" class="form-control" name="strategic_aspects[{{ $index }}][title]" value="{{ $aspect['title'] }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" name="strategic_aspects[{{ $index }}][icon]" value="{{ $aspect['icon'] }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Warna</label>
                                    <select class="form-control" name="strategic_aspects[{{ $index }}][color]" required>
                                        <option value="primary" {{ $aspect['color'] == 'primary' ? 'selected' : '' }}>Primary</option>
                                        <option value="success" {{ $aspect['color'] == 'success' ? 'selected' : '' }}>Success</option>
                                        <option value="info" {{ $aspect['color'] == 'info' ? 'selected' : '' }}>Info</option>
                                        <option value="warning" {{ $aspect['color'] == 'warning' ? 'selected' : '' }}>Warning</option>
                                        <option value="danger" {{ $aspect['color'] == 'danger' ? 'selected' : '' }}>Danger</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="strategic_aspects[{{ $index }}][description]" rows="3" required>{{ $aspect['description'] }}</textarea>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeAspect(this)">
                                <i class="mdi mdi-delete me-1"></i>Hapus Aspek
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success" onclick="addAspect()">
                        <i class="mdi mdi-plus me-2"></i>Tambah Aspek
                    </button>
                </div>
            </div>

            <!-- Ekstrakurikuler -->
            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="mdi mdi-soccer me-2"></i>Ekstrakurikuler</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="extracurricular_description" class="form-label">Deskripsi Ekstrakurikuler</label>
                        <textarea class="form-control" id="extracurricular_description" name="extracurricular_description" rows="3" required>{{ $setting->extracurricular_description }}</textarea>
                    </div>
                    <div id="extracurricular-container">
                        @foreach(($setting->daftar_ekstrakurikuler ?? []) as $index => $extra)
                        <div class="extracurricular-item border p-3 mb-3">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nama Ekstrakurikuler</label>
                                    <input type="text" class="form-control" name="extracurricular_list[{{ $index }}][name]" value="{{ $extra['name'] }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Icon (Bootstrap Icons)</label>
                                    <input type="text" class="form-control" name="extracurricular_list[{{ $index }}][icon]" value="{{ $extra['icon'] }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Warna</label>
                                    <select class="form-control" name="extracurricular_list[{{ $index }}][color]" required>
                                        <option value="primary" {{ $extra['color'] == 'primary' ? 'selected' : '' }}>Primary</option>
                                        <option value="success" {{ $extra['color'] == 'success' ? 'selected' : '' }}>Success</option>
                                        <option value="info" {{ $extra['color'] == 'info' ? 'selected' : '' }}>Info</option>
                                        <option value="warning" {{ $extra['color'] == 'warning' ? 'selected' : '' }}>Warning</option>
                                        <option value="danger" {{ $extra['color'] == 'danger' ? 'selected' : '' }}>Danger</option>
                                        <option value="purple" {{ $extra['color'] == 'purple' ? 'selected' : '' }}>Purple</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeExtracurricular(this)">
                                <i class="mdi mdi-delete me-1"></i>Hapus Ekstrakurikuler
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success" onclick="addExtracurricular()">
                        <i class="mdi mdi-plus me-2"></i>Tambah Ekstrakurikuler
                    </button>
                </div>
            </div>

            <!-- Narahubung -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="mdi mdi-phone me-2"></i>Narahubung PPDB</h5>
                </div>
                <div class="card-body">
                    <div id="contacts-container">
                        @foreach(($setting->narahubung ?? []) as $index => $contact)
                        <div class="contact-item border p-3 mb-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="contact_persons[{{ $index }}][name]" value="{{ $contact['name'] }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" name="contact_persons[{{ $index }}][phone]" value="{{ $contact['phone'] }}" required>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeContact(this)">
                                <i class="mdi mdi-delete me-1"></i>Hapus Kontak
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success" onclick="addContact()">
                        <i class="mdi mdi-plus me-2"></i>Tambah Kontak
                    </button>
                </div>
            </div>

            <!-- Link Pendaftaran -->
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="mdi mdi-link me-2"></i>Link Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="registration_link" class="form-label">Link Pendaftaran</label>
                            <input type="url" class="form-control" id="registration_link" name="registration_link" value="{{ $setting->registration_link }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="qr_code_image" class="form-label">QR Code Image</label>
                            <input type="file" class="form-control" id="qr_code_image" name="qr_code_image" accept="image/*">
                            @if($setting->qr_code_image)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($setting->qr_code_image) }}" alt="QR Code" class="img-thumbnail" style="max-width: 100px;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slogan -->
            <div class="card mt-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="mdi mdi-format-quote-close me-2"></i>Slogan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="slogan_title" class="form-label">Judul Slogan</label>
                            <input type="text" class="form-control" id="slogan_title" name="slogan_title" value="{{ $setting->slogan_title }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="slogan_subtitle" class="form-label">Sub Judul Slogan</label>
                            <input type="text" class="form-control" id="slogan_subtitle" name="slogan_subtitle" value="{{ $setting->slogan_subtitle }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4 mb-4">
                <button type="submit" class="btn btn-primary btn-lg px-5">
                    <i class="mdi mdi-content-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let programIndex = {{ count($setting->program_unggulan ?? []) }};
let aspectIndex = {{ count($setting->aspek_strategis ?? []) }};
let extracurricularIndex = {{ count($setting->daftar_ekstrakurikuler ?? []) }};
let contactIndex = {{ count($setting->narahubung ?? []) }};
let programIndex = {{ count($setting->program_unggulan ?? []) }};
let aspectIndex = {{ count($setting->aspek_strategis ?? []) }};
let extracurricularIndex = {{ count($setting->daftar_ekstrakurikuler ?? []) }};
let contactIndex = {{ count($setting->narahubung ?? []) }};

function addRequirement() {
    const container = document.getElementById('requirements-container');
    const div = document.createElement('div');
    div.className = 'requirement-item mb-3';
    div.innerHTML = `
        <div class="input-group">
            <input type="text" class="form-control" name="requirements[]" required>
            <button type="button" class="btn btn-danger remove-requirement" onclick="removeRequirement(this)">
                <i class="mdi mdi-delete"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
}

function removeRequirement(button) {
    button.closest('.requirement-item').remove();
}

function addProgram() {
    const container = document.getElementById('programs-container');
    const div = document.createElement('div');
    div.className = 'program-item border p-3 mb-3';
    div.innerHTML = `
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Judul Program</label>
                <input type="text" class="form-control" name="featured_programs[${programIndex}][title]" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Icon (Bootstrap Icons)</label>
                <input type="text" class="form-control" name="featured_programs[${programIndex}][icon]" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Warna</label>
                <select class="form-control" name="featured_programs[${programIndex}][color]" required>
                    <option value="primary">Primary</option>
                    <option value="success">Success</option>
                    <option value="info">Info</option>
                    <option value="warning">Warning</option>
                    <option value="danger">Danger</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" name="featured_programs[${programIndex}][description]" rows="3" required></textarea>
        </div>
        <button type="button" class="btn btn-danger btn-sm" onclick="removeProgram(this)">
            <i class="mdi mdi-delete me-1"></i>Hapus Program
        </button>
    `;
    container.appendChild(div);
    programIndex++;
}

function removeProgram(button) {
    button.closest('.program-item').remove();
}

function addAspect() {
    const container = document.getElementById('aspects-container');
    const div = document.createElement('div');
    div.className = 'aspect-item border p-3 mb-3';
    div.innerHTML = `
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Judul Aspek</label>
                <input type="text" class="form-control" name="strategic_aspects[${aspectIndex}][title]" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Icon (Bootstrap Icons)</label>
                <input type="text" class="form-control" name="strategic_aspects[${aspectIndex}][icon]" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Warna</label>
                <select class="form-control" name="strategic_aspects[${aspectIndex}][color]" required>
                    <option value="primary">Primary</option>
                    <option value="success">Success</option>
                    <option value="info">Info</option>
                    <option value="warning">Warning</option>
                    <option value="danger">Danger</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" name="strategic_aspects[${aspectIndex}][description]" rows="3" required></textarea>
        </div>
        <button type="button" class="btn btn-danger btn-sm" onclick="removeAspect(this)">
            <i class="mdi mdi-delete me-1"></i>Hapus Aspek
        </button>
    `;
    container.appendChild(div);
    aspectIndex++;
}

function removeAspect(button) {
    button.closest('.aspect-item').remove();
}

function addExtracurricular() {
    const container = document.getElementById('extracurricular-container');
    const div = document.createElement('div');
    div.className = 'extracurricular-item border p-3 mb-3';
    div.innerHTML = `
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Nama Ekstrakurikuler</label>
                <input type="text" class="form-control" name="extracurricular_list[${extracurricularIndex}][name]" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Icon (Bootstrap Icons)</label>
                <input type="text" class="form-control" name="extracurricular_list[${extracurricularIndex}][icon]" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Warna</label>
                <select class="form-control" name="extracurricular_list[${extracurricularIndex}][color]" required>
                    <option value="primary">Primary</option>
                    <option value="success">Success</option>
                    <option value="info">Info</option>
                    <option value="warning">Warning</option>
                    <option value="danger">Danger</option>
                    <option value="purple">Purple</option>
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-danger btn-sm" onclick="removeExtracurricular(this)">
            <i class="mdi mdi-delete me-1"></i>Hapus Ekstrakurikuler
        </button>
    `;
    container.appendChild(div);
    extracurricularIndex++;
}

function removeExtracurricular(button) {
    button.closest('.extracurricular-item').remove();
}

function addContact() {
    const container = document.getElementById('contacts-container');
    const div = document.createElement('div');
    div.className = 'contact-item border p-3 mb-3';
    div.innerHTML = `
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="contact_persons[${contactIndex}][name]" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">No. Telepon</label>
                <input type="text" class="form-control" name="contact_persons[${contactIndex}][phone]" required>
            </div>
        </div>
        <button type="button" class="btn btn-danger btn-sm" onclick="removeContact(this)">
            <i class="mdi mdi-delete me-1"></i>Hapus Kontak
        </button>
    `;
    container.appendChild(div);
    contactIndex++;
}

function removeContact(button) {
    button.closest('.contact-item').remove();
}
</script>
@endsection
