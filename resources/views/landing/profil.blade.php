@extends('landing.layout')

@section('content')
<!-- HERO SECTION -->
<main>
  <section class="hero-section">
    <div data-sal="slide-up" data-sal-duration="900" class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column d-sm text-center ">
      <h1 class="display-3 fw-bold">PROFIL SMK INOVASI DIGITAL MANADO</h1>
      <a href="#profil" class="btn btn-outline-light">Buka Profil Lengkap <i class="bi bi-arrow-down"></i> </a>
    </div>
  </section>
  <!-- End Hero Section -->

  <!-- Section Sejarah sekolah -->
  <section id="profil" class="py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8 order-1">
          <h2 data-sal="slide-up" class="text-uppercase">sejarah sekolah</h2>
          <p data-sal="slide-up" class="text-capitalize text-justify">Sekolah Menengah Kejuruan (SMK) Inovasi Digital Manado didirikan pada
            tahun 2018 dengan tujuan untuk memberikan pendidikan kejuruan yang
            berkualitas dan relevan dengan perkembangan teknologi informasi dan
            komunikasi. Sekolah ini berkomitmen untuk mencetak lulusan yang siap
            menghadapi tantangan dunia kerja di era digital</p>
          <h5 data-sal="slide-up" class="text-uppercase">arti logo sekolah</h5>
          <p data-sal="slide-up" class="text-capitalize text-justify">Logo Tut Wuri Handayani, dengan simbol obor menyala dan lingkaran
            biru, melambangkan semangat pendidikan yang mencerdaskan. Tut Wuri
            Handayani (dari belakang memberi dorongan) adalah filosofi Ki Hajar
            Dewantara yang menekankan peran pendidik untuk memotivasi siswa
            berpikir mandiri. Obor melambangkan ilmu pengetahuan, nyala apinya
            sebagai cahaya kebenaran, sedangkan lingkaran biru menggambarkan dunia
            pendidikan yang utuh dan tak terbatas.</p>
        </div>

        <div class="col-md-4 text-center order-md-2 pb-3 pb-sm-0">
          <img data-sal="slide-up" src="{{ asset('assets/img/logo-sekolah-tut-wuri-handayani.avif') }}" alt="Logo Sekolah SMK Inovasi Digital Manado" loading="lazy" class="img-fluid w-75 logo-sekolah scale-up">
        </div>
      </div>
    </div>
  </section>
  <!-- End Section -->

  <!-- Section visi,misi -->
  <section class="py-5">
    <div class="container">
      <h2 class="text-center text-uppercase"></h2>
      <div class="row">
        <!-- Visi -->
        <div class="col-md-4 mb-4">
          <div data-sal="zoom-in" class="card h-100 scale-up">
            <div class="card-body text-center">
              <i class="bi bi-stars text-warning display-5"></i>
              <h5 class="card-title">VISI</h5>
              <p class="card-text text-center">Menjadi SMK unggulan yang menghasilkan lulusan kompeten, berkarakter, dan siap bersaing di era global melalui penguasaan teknologi dan kewirausahaan</p>
            </div>
          </div>
        </div>
        <!-- Misi -->
        <div class="col-md-4 mb-4">
          <div data-sal="zoom-in" class="card h-100 scale-up">
            <div class="card-body text-center">
              <i class="bi bi-compass text-primary display-5"></i>
              <h5 class="card-title">MISI</h5>
              <p class="card-text text-center">Kami berkomitmen menerapkan kurikulum berbasis industri, membangun kemitraan dengan dunia kerja, dan mengembangkan jiwa kewirausahaan serta karakter siswa melalui pembelajaran teknologi dan nilai-nilai holistik</p>
            </div>
          </div>
        </div>
        <!-- Tujuan -->
        <div class="col-md-4 mb-4">
          <div data-sal="zoom-in" class="card h-100 scale-up">
            <div class="card-body text-center">
              <i class="bi bi-bullseye text-success display-5"></i>
              <h5 class="card-title">TUJUAN</h5>
              <p class="card-text text-center">Menghasilkan lulusan bersertifikasi dengan 85% penyerapan di dunia kerja atau perguruan tinggi, mendorong 20% alumni berwirausaha, dan menjadi pelopor SMK berbasis teknologi serta pendidikan karakter</p>
            </div>
          </div>
        </div>
        <!--  -->
      </div>
    </div>
  </section>
  <!-- End Section -->

  <!-- Section Fasilitas Sekolah -->
  <section id="Fasilitas-Sekolah" class="py-5">
    <div class="container">
      <h2 class="text-center mb-3">Fasilitas Sekolah</h2>
      <div id="carouselExampleFade" class="carousel slide carousel-fade carousel-dark">
        <div class="carousel-inner">
          <!-- Item 1 -->
          <div class="carousel-item active">
            <div class="card mx-auto text-white" style="max-width: 600px;">
              <img src="{{ asset('assets/img/Lab-Komputer-SMK-Inovasi-digital-manado.avif') }}" class="card-img img-rpl" alt="Lab Komputer" >
              <div class="card-img-overlay d-flex flex-column justify-content-end img-bg-shadow">
                <h5 class="card-title"><i class="bi bi-pc-display me-2"></i>Lab Komputer</h5>
                <p class="card-text mb-3">Ruangan ber-AC dengan 150 unit PC i7 generasi terbaru, mendukung praktikum jaringan komputer, pemrograman, dan desain grafis</p>
              </div>
            </div>
          </div>
          <!-- Item 2 -->
          <div class="carousel-item ">
            <div class="card mx-auto text-white" style="max-width: 600px;">
              <img src="{{ asset('assets/img/Lab-Fiber-Optic-SMK-Inovasi-Digital-Manado.avif') }}" class="card-img img-rpl" alt="Lab Fiber Optic" >
              <div class="card-img-overlay d-flex flex-column justify-content-end img-bg-shadow">
                <h5 class="card-title"><i class="bi bi-router me-2"></i>Lab Fiber Optic</h5>
                <p class="card-text mb-3"> Praktik langsung instalasi jaringan fiber optic dengan tools
                  profesional: fusion splicer, OTDR dan fiber tester</p>
              </div>
            </div>
          </div>
          <!-- Item 3 -->
          <div class="carousel-item ">
            <div class="card mx-auto text-white" style="max-width: 600px;">
              <img src="{{ asset('assets/img/Perpustakaan-Digital-SMK-Digital-Manad.avif') }}" class="card-img img-rpl" alt="Perpustakaan Digital" >
              <div class="card-img-overlay d-flex flex-column justify-content-end img-bg-shadow">
                <h5 class="card-title"><i class="bi bi-journals me-2"></i>Perpustakaan Digital</h5>
                <p class="card-text mb-3">Akses 10.000+ e-book dan jurnal online melalui 20 komputer khusus dengan ruang diskusi berkapasitas 250 siswa</p>
              </div>
            </div>
          </div>
          <!-- item 4 -->
          <div class="carousel-item ">
            <div class="card mx-auto text-white" style="max-width: 600px;">
              <img src="{{ asset('assets/img/Lapangan-Basket-SMK-Inovasi-Digital-Manado.avif') }}" class="card-img img-rpl" alt="Lapangan Basket" >
              <div class="card-img-overlay d-flex flex-column justify-content-end img-bg-shadow">
                <h5 class="card-title"><i class="bi bi-dribbble me-2"></i>Lapngan Basket</h5>
                <p class="card-text mb-3">Lapangan standar FIBA dengan flooring khusus dan lighting LED untuk latihan maupun pertandingan resmi</p>
              </div>
            </div>
          </div>
          <!-- item 5 -->
          <div class="carousel-item ">
            <div class="card mx-auto text-white" style="max-width: 600px;">
              <img src="{{ asset('assets/img/Ruang-Auditorium-SMK-Inovasi-Digital-Manado.avif') }}" class="card-img img-rpl" alt="Auditorium" >
              <div class="card-img-overlay d-flex flex-column justify-content-end img-bg-shadow">
                <h5 class="card-title"><i class="bi bi-buildings me-2"></i>Auditorium</h5>
                <p class="card-text mb-3">Ruang serbaguna berkapasitas 756 orang dengan sistem akustik profesional dan peralatan multimedia lengkap</p>
              </div>
            </div>
          </div>
          <!-- item 6 -->
          <div class="carousel-item ">
            <div class="card mx-auto text-white" style="max-width: 600px;">
              <img src="{{ asset('assets/img/Kantin-Sehat-SMK-Inovasi-Digital-Manado.avif') }}" class="card-img img-rpl" alt="Kantin Sehat" >
              <div class="card-img-overlay d-flex flex-column justify-content-end img-bg-shadow">
                <h5 class="card-title"><i class="bi bi-cup-hot me-2"></i>Kantin Sehat</h5>
                <p class="card-text mb-3">Menyajikan makanan bergizi seimbang dengan sistem pembayaran digital dan area makan berkapasitas 500 orang</p>
              </div>
            </div>
          </div>
          <!-- end -->
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev" aria-label="Sebelumnya">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next" aria-label="Berikutnya">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </section>
    <!-- End Section -->

    <!-- Section kontak -->
    <section class="py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div data-sal="zoom-in" class="card border-0 shadow scale-up">
              <div class="card-body mb-3">
                <h3 class="text-center">Kontak Kami</h3>
                <!-- Lokasi -->
                <div class="d-flex align-items-center mb-3">
                  <i class="bi bi-geo-alt text-primary fs-3 me-3"></i>
                  <div>
                    <h6 class="mb-0">Alamat</h6>
                    <a href="https://www.google.com/maps/@1.565886,124.924404,2075m/data=!3m1!1e3?hl=en&entry=ttu&g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="text-link">Jl. Sam Ratulangi No. 45 Kelurahan Tikala, Kec. Wenang <br> Kota Manado, Sulawesi Utara 95124</a>
                  </div>
                </div>
                <!-- Whatsapp -->
                <div class="d-flex align-items-center mb-3">
                  <i class="bi bi-whatsapp text-success fs-3 me-3"></i>
                  <div>
                    <h6 class="mb-0">WhatsApp</h6>
                    <a href="https://wa.me/+62812345678910" target="_blank" class="text-link">+62 824064 9332</a>
                  </div>
                </div>
                <!-- Email -->
                <div class="d-flex align-items-center mb-3">
                  <i class="bi bi-envelope text-primary fs-3 me-3"></i>
                  <div>
                    <h6 class="mb-0">Email</h6>
                    <a href="mailto:miawhhh6@gmail.com" target="_blank" class="text-link">info@digitalmanado.sch.id</a>
                  </div>
                </div>
                <!-- Download Brosur -->
                <div class="d-flex align-items-center mb-3">
                  <a href="{{ asset('assets/img/Brosur-Sekolah-SMK-Inovasi-Digital-Manado.png') }}" download="Brosur Sekolah SMK Inovasi Digital Manado" class="btn btn-outline-primary">
                    <i class="bi bi-file-earmark-arrow-down"></i>
                    Unduh Brosur Sekolah</a>
                </div>
                <!-- end -->
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div data-sal="zoom-in" class="ratio ratio-16x9 rounded-3 shadow scale-up">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.052666044459!2d124.92571041691005!3d1.5668483031330651!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3287a100083491e7%3A0xe42e8a93f1364fcc!2sGereja%20Bethel%20Indonesia%20(Petros)!5e1!3m2!1sen!2sid!4v1747208929503!5m2!1sen!2sid"
                width="600"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Peta Lokasi SMK Inovasi Digital Manado">
              </iframe>
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- End Section -->
</main>
@endsection
