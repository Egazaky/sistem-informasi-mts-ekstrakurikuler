@extends('landing.layout')

@section('content')
<!-- HERO SECTION -->
<main>
  <section class="hero-section">
    <div data-sal="slide-up" data-sal-duration="900" class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column text-center">
      <h1 class="display-3 fw-bold">{{ $content->judul_hero ?? 'PENERIMAAN PESERTA DIDIK BARU' }}</h1>
      <h2 class="display-5 fw-bold">{{ $content->subjudul_hero ?? 'MTS AL-ISLAM JEPARA' }}</h2>
      <h3 class="display-6 fw-bold">{{ $content->tahun_ajaran ?? 'TAHUN AJARAN 2025/2026' }}</h3>
      <div class="mt-4">
        <span class="badge bg-warning text-dark fs-4 px-4 py-3 rounded-pill">{{ $content->badge_hero ?? 'GRATIS BIAYA PENDAFTARAN' }}</span>
      </div>
      <a href="#pendaftaran" class="btn btn-outline-light mt-4">Daftar Sekarang <i class="bi bi-arrow-down"></i></a>
    </div>
  </section>
  <!-- End Hero Section -->

  <!-- Section Syarat Pendaftaran -->
  <section id="syarat-pendaftaran" class="py-5 bg-light">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-6">
          <h2 class="section-title text-center">Syarat Pendaftaran</h2>
          <div class="card border-0 shadow h-100">
            <div class="card-body">
              @if(!empty($content->syarat_pendaftaran))
                <ul>
                  @foreach(explode('|', $content->syarat_pendaftaran) as $syarat)
                    <li>{{ $syarat }}</li>
                  @endforeach
                </ul>
                <p><em>{{ $content->catatan_syarat_pendaftaran }}</em></p>
              @else
                <p>Syarat pendaftaran belum tersedia.</p>
              @endif
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <h2 class="section-title text-center">Info Pendaftaran</h2>
          <div class="card border-0 shadow h-100">
            <div class="card-body">
              {!! $content->info_pendaftaran ?? '<p>Info pendaftaran belum tersedia.</p>' !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Section -->

  <!-- Section Gelombang Pendaftaran -->
  <section class="py-5">
    <div class="container">
      <h2 class="section-title text-center">Gelombang Pendaftaran</h2>
      <div class="row g-4">
        <div class="col-lg-6">
          <div class="card border-0 shadow h-100">
            <div class="card-body text-center">
              <h4 class="text-primary mb-3">{{ $content->judul_gelombang_1 ?? 'Gelombang 1' }}</h4>
              <p class="mb-0 fs-5">{{ $content->tanggal_gelombang_1 ?? '-' }}</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card border-0 shadow h-100">
            <div class="card-body text-center">
              <h4 class="text-primary mb-3">{{ $content->judul_gelombang_2 ?? 'Gelombang 2' }}</h4>
              <p class="mb-0 fs-5">{{ $content->tanggal_gelombang_2 ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Section -->

  <!-- Section Lokasi Pendaftaran -->
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="section-title text-center">Lokasi Pendaftaran</h2>
      <div class="card border-0 shadow">
        <div class="card-body text-center">
          <h4 class="mb-3">{{ $content->nama_lokasi ?? 'Lokasi belum tersedia' }}</h4>
          <p class="mb-2 fs-5">{{ $content->alamat_lokasi ?? '' }}</p>
          @if(!empty($content->catatan_lokasi))
            <p class="text-muted"><em>{{ $content->catatan_lokasi }}</em></p>
          @endif
        </div>
      </div>
    </div>
  </section>
  <!-- End Section -->

  <!-- Section Program Unggulan -->
  <section class="py-5">
    <div class="container">
      <h2 class="section-title text-center">Program Unggulan</h2>
      <div class="row g-4">
        @php
          $programs = !empty($content->program_unggulan) ? explode('|', $content->program_unggulan) : [];
          $program_images = !empty($content->program_unggulan_images) ? explode('|', $content->program_unggulan_images) : [];
        @endphp
        @if(count($programs))
          @foreach($programs as $i => $program)
            <div class="col-md-4 col-lg-3">
              <div class="card card-feature text-center h-100">
                <div class="icon-wrapper mb-2">
                  @if(isset($program_images[$i]) && $program_images[$i])
                    <img src="{{ asset('storage/'.$program_images[$i]) }}" alt="img" style="max-width:60px;max-height:60px;object-fit:cover;border-radius:50%;">
                  @else
                    <i class="bi bi-book text-primary display-6"></i>
                  @endif
                </div>
                <h5 class="mt-3 fw-semibold">{{ $program }}</h5>
              </div>
            </div>
          @endforeach
        @else
          <p class="text-center">Program unggulan belum tersedia.</p>
        @endif
      </div>
    </div>
  </section>
  <!-- End Section -->

  <!-- Section Aspek Strategis -->
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="section-title text-center">Aspek Strategis</h2>
      <div class="row g-4">
        @php
          $aspeks = !empty($content->aspek_strategis) ? explode('|', $content->aspek_strategis) : [];
          $aspek_images = !empty($content->aspek_strategis_images) ? explode('|', $content->aspek_strategis_images) : [];
        @endphp
        @if(count($aspeks))
          @foreach($aspeks as $i => $aspek)
            <div class="col-md-6 col-lg-4">
              <div class="card card-feature h-100 text-center">
                <div class="icon-wrapper mb-2">
                  @if(isset($aspek_images[$i]) && $aspek_images[$i])
                    <img src="{{ asset('storage/'.$aspek_images[$i]) }}" alt="img" style="max-width:60px;max-height:60px;object-fit:cover;border-radius:50%;">
                  @else
                    <i class="bi bi-lightbulb text-primary display-6"></i>
                  @endif
                </div>
                <h6 class="mt-3 fw-semibold">{{ $aspek }}</h6>
              </div>
            </div>
          @endforeach
        @else
          <p class="text-center">Aspek strategis belum tersedia.</p>
        @endif
      </div>
    </div>
  </section>
  <!-- End Section -->

  <!-- Section Ekstrakurikuler -->
  <section class="py-5">
    <div class="container">
      <h2 class="section-title text-center">Ekstrakurikuler</h2>
      <div class="row g-4">
        @php
          $ekstras = !empty($content->daftar_ekstrakurikuler) ? explode('|', $content->daftar_ekstrakurikuler) : [];
          $ekstra_images = !empty($content->daftar_ekstrakurikuler_images) ? explode('|', $content->daftar_ekstrakurikuler_images) : [];
        @endphp
        @if(count($ekstras))
          @foreach($ekstras as $i => $ekstra)
            <div class="col-md-4 col-lg-3">
              <div class="card card-feature text-center h-100">
                <div class="icon-wrapper mb-2">
                  @if(isset($ekstra_images[$i]) && $ekstra_images[$i])
                    <img src="{{ asset('storage/'.$ekstra_images[$i]) }}" alt="img" style="max-width:60px;max-height:60px;object-fit:cover;border-radius:50%;">
                  @else
                    <i class="bi bi-star-fill text-primary display-6"></i>
                  @endif
                </div>
                <h6 class="mt-3 fw-semibold">{{ $ekstra }}</h6>
              </div>
            </div>
          @endforeach
        @else
          <p class="text-center">Ekstrakurikuler belum tersedia.</p>
        @endif
      </div>
      <p class="text-center mt-4 text-muted">{{ $content->deskripsi_ekstrakurikuler ?? '' }}</p>
    </div>
  </section>
  <!-- End Section -->

<!-- Section Kontak & Link Pendaftaran -->
<section id="pendaftaran" class="py-5 bg-light">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-6">
        <h3 class="section-title text-center">Narahubung PPDB</h3>
        <div class="card border-0 shadow h-100 text-center">
          <div class="card-body">
            @if(!empty($content->narahubung))
              @foreach(explode('|', $content->narahubung) as $kontak)
                @php
                  // Cek apakah kontak berupa angka (nomor telepon) → buat link tel/wa
                  $nomor = preg_replace('/\D/', '', $kontak);
                  $waLink = "https://wa.me/".$nomor;
                @endphp
                <a href="{{ $waLink }}" target="_blank" class="btn btn-success w-100 mb-2">
                  <i class="bi bi-whatsapp me-2"></i> {{ $kontak }}
                </a>
              @endforeach
            @else
              <p>Narahubung belum tersedia.</p>
            @endif
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <h3 class="section-title text-centerx">Link Pendaftaran</h3>
        <div class="card border-0 shadow text-center h-100">
            <div class="card-body">
            <h5 class="card-title">Daftar Online</h5>
            {{-- <p class="card-text">Klik tombol di bawah ini untuk mendaftar</p> --}}
            <a href="{{ $content->link_pendaftaran ?? '#' }}" target="_blank" class="btn btn-primary">
                <i class="bi bi-link-45deg me-2"></i> Klik Disini
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


  <!-- Section Slogan -->
  <section class="py-5">
    <div class="container text-center">
      <div data-sal="zoom-in" class="card border-0 shadow">
        <div class="card-body py-5">
          <h2 class="display-4 text-primary fw-bold">{{ $content->judul_slogan ?? 'Madrasah Maju, Bermutu, Mendunia' }}</h2>
          <p class="lead text-muted">{{ $content->subjudul_slogan ?? 'Bergabunglah dengan kami untuk meraih pendidikan terbaik' }}</p>
        </div>
      </div>
    </div>
  </section>
  <!-- End Section -->

  @include('landing.partials.footer')
</main>

<style>
.hero-section {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  min-height: 70vh;
  display: flex;
  align-items: center;
}
.card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.card:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.1); }
.badge { animation: pulse 2s infinite; }
@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.05); }
  100% { transform: scale(1); }
}
.section-title {
  text-transform: uppercase;
  font-weight: 700;
  color: #007bff;
  margin-bottom: 1.5rem;
  position: relative;
  display: block;
  text-align: center;
}
.section-title::after {
  content: "";
  display: block;
  width: 60px;
  height: 3px;
  background: #007bff;
  margin: 0.5rem auto 0;
  border-radius: 2px;
}
.icon-wrapper {
  width: 80px;
  height: 80px;
  background: #eef4ff;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
}
.card-feature {
  border: 0;
  border-radius: 15px;
  padding: 20px;
}
</style>
@endsection
