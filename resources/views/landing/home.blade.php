@extends('landing.layout')

@section('content')
<main>
    <!-- HERO SECTION -->
    <section class="hero-section">
        <div data-sal="slide-up" data-sal-duration="900"
             class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column text-center">
            <h1 class="display-3 fw-bold">
                {{ optional($homeSetting)->judul_utama ?? 'MTS AL-ISLAM JEPARA' }}
            </h1>
            <h2 class="fs-4">
                <em>{{ optional($homeSetting)->subjudul_utama ?? 'Membangun Pemikir Digital, Menciptakan Solusi Masa Depan' }}</em>
            </h2>
            <a href="#mengapa" class="btn btn-outline-light fw-bold m-3 text-capitalize">
                Temukan Potensimu Sekarang! <i class="bi bi-arrow-down"></i>
            </a>
        </div>
    </section>
    <!-- End Hero Section -->

    <!-- WHY CHOOSE US SECTION -->
    <section id="mengapa" class="py-5 bg-dark text-capitalize text-white text-center">
        <div class="container">
            <h2 class="text-center mb-3 text-uppercase">
                {{ optional($homeSetting)->mengapa_pilih_kami ?? 'Mengapa Pilih Kami?' }}
            </h2>
            <div class="row">
                <!-- Akreditasi -->
                <div data-sal="slide-up" data-sal-duration="900" class="col-md-4">
                    <i class="bi bi-award fs-1"></i>
                    <h5>{{ optional($homeSetting)->akreditasi ?? 'Akreditasi A' }}</h5>
                    <p>{{ optional($homeSetting)->deskripsi_akreditasi ?? 'Terakreditasi nasional dengan standar pendidikan tinggi' }}</p>
                </div>

                <!-- Fasilitas -->
                <div data-sal="slide-up" data-sal-duration="900" class="col-md-4">
                    <i class="bi bi-buildings fs-1"></i>
                    <h5>Fasilitas Lengkap</h5>
                    <ul class="list-unstyled">
                        @if(optional($homeSetting)->fasilitas)
                            @foreach(explode(',', $homeSetting->fasilitas) as $fasilitas)
                                <li class="mb-2"><i class="bi bi-dot"></i> {{ trim($fasilitas) }}</li>
                            @endforeach
                        @else
                            <li><i class="bi bi-pc-display"></i> Laboratorium Komputer</li>
                            <li><i class="bi bi-book"></i> Perpustakaan Besar</li>
                        @endif
                    </ul>
                </div>

                <!-- Alumni -->
                <div data-sal="slide-up" data-sal-duration="900" class="col-md-4">
                    <i class="bi bi-people fs-1"></i>
                    <h5>Alumni Sukses</h5>
                    <p>{{ optional($homeSetting)->alumni_sukses ?? '90% lulusan diterima di perguruan tinggi ternama' }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- END WHY CHOOSE US -->

    <!-- SAMBUTAN KEPALA SEKOLAH -->
    <section id="Sambutan" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Foto Kepala Sekolah -->
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <img src="{{ optional($homeSetting)->foto_kepala_sekolah ? asset('storage/' . $homeSetting->foto_kepala_sekolah) : asset('img/kepsekmts.jpg') }}"
                         alt="Foto Kepala Sekolah"
                         class="img-fluid rounded shadow"
                         style="max-height: 350px; object-fit: cover;">
                </div>
                <!-- Sambutan -->
                <div class="col-md-8">
                    <h2 class="text-uppercase mb-4">Sambutan Kepala Sekolah</h2>
                    <p>{{ optional($homeSetting)->sambutan_kepala_sekolah ?? 'Selamat datang di MTS AL-ISLAM JEPARA. Kami berkomitmen memberikan pendidikan terbaik...' }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- END SAMBUTAN -->

    <!-- BERITA TERBARU -->
    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="text-uppercase mb-3 fw-bold">Berita Terbaru</h2>
            <a href="{{ route('landing-berita') }}" class="btn btn-outline-dark text-capitalize mb-4 mb-md-3">
                Berita Lainnya
            </a>
        </div>

        <div class="row g-3">
            @forelse($berita as $index => $item)
                <!-- Berita Utama -->
                @if($index === 0)
                    <div class="col-md-8">
                        <div data-sal="slide-up" class="card text-white border-0 overflow-hidden">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('img/default-news.jpg') }}"
                                 class="card-img"
                                 style="height: 500px; object-fit: cover" />
                            <div class="card-img-overlay img-bg-shadow d-flex flex-column justify-content-end p-3 p-md-4">
                                <h3 class="card-title fs-2 mb-2">{{ $item->title }}</h3>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <i class="bi bi-calendar-event"></i>
                                    <span>{{ $item->created_at->translatedFormat('l, d F Y') }}</span>
                                </div>
                                <a href="{{ route('landing-berita-show', $item->id) }}"
                                   class="btn btn-light btn-sm text-capitalize align-self-start py-2 px-3">
                                   Baca Selengkapnya <i class="bi bi-chevron-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Berita Samping -->
                    <div class="col-md-4">
                        <div data-sal="slide-up" class="card text-white border-0 overflow-hidden mb-3">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('img/default-news.jpg') }}"
                                 class="card-img"
                                 style="height: 240px; object-fit: cover" />
                            <div class="card-img-overlay img-bg-shadow d-flex flex-column justify-content-end p-3">
                                <h5 class="card-title">{{ $item->title }}</h5>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-calendar-event"></i>
                                    <span>{{ $item->created_at->translatedFormat('l, d F Y') }}</span>
                                </div>
                                <a href="{{ route('landing-berita-show', $item->id) }}"
                                   class="btn btn-light btn-sm align-self-start py-1 px-2">
                                   Baca Selengkapnya <i class="bi bi-chevron-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center">
                    <p>Tidak ada berita terbaru.</p>
                </div>
            @endforelse
        </div>
    </div>
    <!-- END BERITA -->

    <!-- FOOTER -->
    @include('landing.partials.footer')
</main>
@endsection
