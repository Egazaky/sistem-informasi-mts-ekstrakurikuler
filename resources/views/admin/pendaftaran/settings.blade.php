@extends('admin.template')

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title">Pengaturan Halaman Pendaftaran</h4>

                {{-- Alert Success --}}
                @if(session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.pendaftaran.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- HERO SECTION --}}
                    <h5 class="mt-4">Hero Section</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Judul Hero</label>
                            <input type="text" class="form-control" name="judul_hero" value="{{ old('judul_hero', $content->judul_hero) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Sub Judul Hero</label>
                            <input type="text" class="form-control" name="subjudul_hero" value="{{ old('subjudul_hero', $content->subjudul_hero) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tahun Ajaran</label>
                            <input type="text" class="form-control" name="tahun_ajaran" value="{{ old('tahun_ajaran', $content->tahun_ajaran) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Badge Hero</label>
                            <input type="text" class="form-control" name="badge_hero" value="{{ old('badge_hero', $content->badge_hero) }}">
                        </div>
                    </div>

                    {{-- SYARAT PENDAFTARAN --}}
                    <h5 class="mt-4">Syarat Pendaftaran</h5>
                    @php
                        $syarat = $content->syarat_pendaftaran ? explode('|', $content->syarat_pendaftaran) : [''];
                    @endphp
                    <div id="syarat-container">
                        @foreach($syarat as $s)
                            <div class="input-group mb-2">
                                <input type="text" name="syarat_pendaftaran[]" class="form-control" value="{{ $s }}">
                                <button type="button" class="btn btn-danger" onclick="hapusInput(this)">Hapus</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mb-3" onclick="tambahInput('syarat-container','syarat_pendaftaran[]')">+ Tambah Syarat</button>

                    <div class="mb-3">
                        <label>Catatan Syarat</label>
                        <input type="text" name="catatan_syarat_pendaftaran" class="form-control" value="{{ old('catatan_syarat_pendaftaran', $content->catatan_syarat_pendaftaran) }}">
                    </div>

                    {{-- INFORMASI PENDAFTARAN --}}
                    <h5 class="mt-4">Informasi Pendaftaran</h5>
                    <div class="mb-3">
                        <label>Informasi Pendaftaran</label>
                        <textarea class="form-control" name="info_pendaftaran" rows="3">{{ old('info_pendaftaran', $content->info_pendaftaran) }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Judul Gelombang 1</label>
                            <input type="text" class="form-control" name="judul_gelombang_1" value="{{ old('judul_gelombang_1', $content->judul_gelombang_1) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Gelombang 1</label>
                            <input type="text" class="form-control" name="tanggal_gelombang_1" value="{{ old('tanggal_gelombang_1', $content->tanggal_gelombang_1) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Judul Gelombang 2</label>
                            <input type="text" class="form-control" name="judul_gelombang_2" value="{{ old('judul_gelombang_2', $content->judul_gelombang_2) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Gelombang 2</label>
                            <input type="text" class="form-control" name="tanggal_gelombang_2" value="{{ old('tanggal_gelombang_2', $content->tanggal_gelombang_2) }}">
                        </div>
                    </div>

                    {{-- LOKASI PENDAFTARAN --}}
                    <h5 class="mt-4">Lokasi Pendaftaran</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Nama Lokasi</label>
                            <input type="text" class="form-control" name="nama_lokasi" value="{{ old('nama_lokasi', $content->nama_lokasi) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Alamat Lokasi</label>
                            <input type="text" class="form-control" name="alamat_lokasi" value="{{ old('alamat_lokasi', $content->alamat_lokasi) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Catatan Lokasi</label>
                            <input type="text" class="form-control" name="catatan_lokasi" value="{{ old('catatan_lokasi', $content->catatan_lokasi) }}">
                        </div>
                    </div>

                    {{-- PROGRAM UNGGULAN --}}
                    <h5 class="mt-4">Program Unggulan</h5>
                    @php
                        $program = $content->program_unggulan ? explode('|', $content->program_unggulan) : [''];
                    @endphp
                    <div id="program-container">
                        @php
                            $program_images = $content->program_unggulan_images ? explode('|', $content->program_unggulan_images) : [];
                        @endphp
                        @foreach($program as $i => $p)
                            <div class="input-group mb-2 align-items-center">
                                <input type="text" name="program_unggulan[]" class="form-control" value="{{ $p }}">
                                <input type="file" name="program_unggulan_images[]" class="form-control ms-2" accept="image/*">
                                @if(isset($program_images[$i]) && $program_images[$i])
                                    <img src="{{ asset('storage/'.$program_images[$i]) }}" alt="img" style="height:40px; margin-left:8px;">
                                @endif
                                <button type="button" class="btn btn-danger ms-2" onclick="hapusInput(this)">Hapus</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mb-3" onclick="tambahInputGambar('program-container','program_unggulan[]','program_unggulan_images[]')">+ Tambah Program</button>

                    {{-- ASPEK STRATEGIS --}}
                    <h5 class="mt-4">Aspek Strategis</h5>
                    @php
                        $aspek = $content->aspek_strategis ? explode('|', $content->aspek_strategis) : [''];
                    @endphp
                    <div id="aspek-container">
                        @php
                            $aspek_images = $content->aspek_strategis_images ? explode('|', $content->aspek_strategis_images) : [];
                        @endphp
                        @foreach($aspek as $i => $a)
                            <div class="input-group mb-2 align-items-center">
                                <input type="text" name="aspek_strategis[]" class="form-control" value="{{ $a }}">
                                <input type="file" name="aspek_strategis_images[]" class="form-control ms-2" accept="image/*">
                                @if(isset($aspek_images[$i]) && $aspek_images[$i])
                                    <img src="{{ asset('storage/'.$aspek_images[$i]) }}" alt="img" style="height:40px; margin-left:8px;">
                                @endif
                                <button type="button" class="btn btn-danger ms-2" onclick="hapusInput(this)">Hapus</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mb-3" onclick="tambahInputGambar('aspek-container','aspek_strategis[]','aspek_strategis_images[]')">+ Tambah Aspek</button>

                    {{-- EKSTRAKURIKULER --}}
                    <h5 class="mt-4">Daftar Ekstrakurikuler</h5>
                    @php
                        $ekstra = $content->daftar_ekstrakurikuler ? explode('|', $content->daftar_ekstrakurikuler) : [''];
                    @endphp
                    <div id="ekstra-container">
                        @php
                            $ekstra_images = $content->daftar_ekstrakurikuler_images ? explode('|', $content->daftar_ekstrakurikuler_images) : [];
                        @endphp
                        @foreach($ekstra as $i => $e)
                            <div class="input-group mb-2 align-items-center">
                                <input type="text" name="daftar_ekstrakurikuler[]" class="form-control" value="{{ $e }}">
                                <input type="file" name="daftar_ekstrakurikuler_images[]" class="form-control ms-2" accept="image/*">
                                @if(isset($ekstra_images[$i]) && $ekstra_images[$i])
                                    <img src="{{ asset('storage/'.$ekstra_images[$i]) }}" alt="img" style="height:40px; margin-left:8px;">
                                @endif
                                <button type="button" class="btn btn-danger ms-2" onclick="hapusInput(this)">Hapus</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mb-3" onclick="tambahInputGambar('ekstra-container','daftar_ekstrakurikuler[]','daftar_ekstrakurikuler_images[]')">+ Tambah Ekstrakurikuler</button>

                    <div class="mb-3">
                        <label>Deskripsi Ekstrakurikuler</label>
                        <textarea name="deskripsi_ekstrakurikuler" class="form-control" rows="3">{{ old('deskripsi_ekstrakurikuler', $content->deskripsi_ekstrakurikuler) }}</textarea>
                    </div>

                    {{-- NARAHUBUNG --}}
                    <h5 class="mt-4">Narahubung</h5>
                    @php
                        $narahubung = $content->narahubung ? explode('|', $content->narahubung) : [''];
                    @endphp
                    <div id="narahubung-container">
                        @foreach($narahubung as $n)
                            <div class="input-group mb-2">
                                <input type="text" name="narahubung[]" class="form-control" value="{{ $n }}">
                                <button type="button" class="btn btn-danger" onclick="hapusInput(this)">Hapus</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mb-3" onclick="tambahInput('narahubung-container','narahubung[]')">+ Tambah Narahubung</button>

                    {{-- LINK PENDAFTARAN --}}
                    <h5 class="mt-4">Link Pendaftaran</h5>
                    <input type="text" class="form-control mb-3" name="link_pendaftaran" value="{{ old('link_pendaftaran', $content->link_pendaftaran) }}">

                    {{-- SLOGAN --}}
                    <h5 class="mt-4">Slogan</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Judul Slogan</label>
                            <input type="text" class="form-control" name="judul_slogan" value="{{ old('judul_slogan', $content->judul_slogan) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Subjudul Slogan</label>
                            <input type="text" class="form-control" name="subjudul_slogan" value="{{ old('subjudul_slogan', $content->subjudul_slogan) }}">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- JS Untuk Tambah & Hapus Input Dinamis --}}
<script>
    function tambahInputGambar(containerId, name, nameImage) {
        const container = document.getElementById(containerId);
        const div = document.createElement('div');
        div.classList.add('input-group', 'mb-2', 'align-items-center');
        div.innerHTML = `
            <input type="text" name="${name}" class="form-control">
            <input type="file" name="${nameImage}" class="form-control ms-2" accept="image/*">
            <button type="button" class="btn btn-danger ms-2" onclick="hapusInput(this)">Hapus</button>
        `;
        container.appendChild(div);
    }
    function hapusInput(button) {
        button.parentElement.remove();
    }
</script>
@endsection
