<!DOCTYPE html>
<html lang="id">
<head>
    <!-- REQUIRED META TAGS -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- PAGE TITLE -->
    <title>Beranda | MTS AL-ISLAM JEPARA</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}" />
    <!-- BASIC SEO -->
    <meta name="description" content="MTS AL-ISLAM JEPARA: unggul di RPL, TKJ & DKV, berakreditasi A, kurikulum industri, laboratorium modern, komitmen wirausaha & karakter siswa." />
    <meta name="keywords" content="SMK, Inovasi Digital, RPL, TKJ, DKV, pendidikan, teknologi" />
    <meta name="author" content="MTS AL-ISLAM JEPARA" />
    <meta name="robots" content="index, follow" />
    <!-- OPEN GRAPH / FACEBOOK / WHATSAPP -->
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Beranda | MTS AL-ISLAM JEPARA" />
    <meta property="og:description" content="MTS AL-ISLAM JEPARA: unggul di RPL, TKJ & DKV, laboratorium modern, berakreditasi A, siap mencetak profesional digital masa depan" />
    <meta property="og:url" content="https://smk-inovasi-digital-manado-orcin.vercel.app/" />
    <meta property="og:site_name" content="MTS AL-ISLAM JEPARA" />
    <meta property="og:image" content="https://smk-inovasi-digital-manado-orcin.vercel.app/assets/img/hai.png" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <!-- TWITTER CARD -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@YourSchoolTwitter" />
    <meta name="twitter:title" content="Beranda | MTS AL-ISLAM JEPARA" />
    <meta name="twitter:description" content="MTS AL-ISLAM JEPARA: unggul di RPL, TKJ & DKV, laboratorium modern, berakreditasi A, siap mencetak profesional digital masa depan" />
    <meta name="twitter:image" content="https://smk-inovasi-digital-manado-orcin.vercel.app/assets/img/hai.png" />
    <!-- THEME COLOR FOR MOBILE BROWSER -->
    <meta name="theme-color" content="#0055A4" />
    <!-- STRUCTURED DATA (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EducationalOrganization",
      "name": "MTS AL-ISLAM JEPARA",
      "url": "https://smk-inovasi-digital-manado-orcin.vercel.app",
      "logo": "https://smk-inovasi-digital-manado-orcin.vercel.app/assets/img/logo-sekolah-tut-wuri-handayani.avif",
      "sameAs": [
        "https://www.facebook.com/yourpage",
        "https://www.instagram.com/yourpage"
      ],
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Jl. Sam Ratulangi No. 45",
        "addressLocality": "Tikala, Wenang",
        "addressRegion": "Manado",
        "postalCode": "95115",
        "addressCountry": "ID"
      }
    }
    </script>
    <!-- GOOGLE FONTS -->
    <!-- Montserrat font family - Can be changed to other Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- BOOTSTRAP ICONS -->
    <!-- Icon set from Bootstrap Icons v1.11.3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- BOOTSTRAP 5 CSS -->
    <!-- Core Bootstrap CSS - Version 5.3.5 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
      rel="stylesheet"
      crossorigin="anonymous"/>
    <!-- CSS Sal.js -->
    <link rel="stylesheet" href="https://unpkg.com/sal.js@0.8.5/dist/sal.css">
    <!-- JS Sal.js -->
    <script src="https://unpkg.com/sal.js@0.8.5/dist/sal.js"></script>
    <!-- CUSTOM CSS FILES -->
    <!-- Custom stylesheets - Modify these files for styling changes -->
    <!-- Navbar CSS Custome -->
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <!-- Footer CSS Custome -->
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <!-- CSS Custome Page Home/Index -->
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    @yield('head')
</head>
@php
    $profile = App\Models\Profile::first();
@endphp
<body>
    <!-- Navbar component implemented following the tutorial by Code_Jungle:
      • YouTube: https://www.youtube.com/@CodeJungle
      • Instagram: https://www.instagram.com/code.jungle/
      • GitHub: https://github.com/codeboysk
      • Video Reference: https://youtu.be/h5apE3E72wY?si=9W9CfMttM9Fk8WGT
      Thank you, @Code_Jungle, for the clear guidance! -->
<!-- MAIN NAVIGATION -->
<!-- Responsive offcanvas navbar - Replace logo and menu items as needed -->
<nav data-sal="slide-down" data-sal-duration="900" class="navbar navbar-expand-lg fixed-top shadow-lg">
  <div class="container">
    <a class="navbar-brand" href="{{ route('landing') }}">
        <img class="img" src="{{ asset('assets/img/logo.png') }}" alt="Logo Sekolah" width="auto" height="40">
      </a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="offcanvas"
      data-bs-target="#offcanvasNavbar"
      aria-controls="offcanvasNavbar"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div
      class="offcanvas offcanvas-end"
      tabindex="-1"
      id="offcanvasNavbar"
      aria-labelledby="offcanvasNavbarLabel"
    >
      <div class="offcanvas-header">
        <h5 class="offcanvas-title text-uppercase" id="offcanvasNavbarLabel">MTS AL-ISLAM JEPARA</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3 text-capitalize">
          <li class="nav-item">
            <a class="nav-link link-nav mx-lg-2 {{ request()->routeIs('landing') ? 'active' : '' }}" aria-current="page" href="{{ route('landing') }}">beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link link-nav mx-lg-2 {{ request()->routeIs('tentang-kami') ? 'active' : '' }}" href="{{ route('tentang-kami') }}">tentang kami & galeri</a>
          </li>
          <li class="nav-item">
            <a class="nav-link link-nav mx-lg-2 {{ request()->routeIs('pendaftaran') ? 'active' : '' }}" href="{{ route('pendaftaran') }}">pendaftaran</a>
          </li>


          <li class="nav-item">
              <a class="nav-link link-nav mx-lg-2 {{ request()->routeIs('landing-berita') ? 'active' : '' }}" href="{{ route('landing-berita') }}">berita</a>
            </li>
            <li class="nav-item">
              <a class="nav-link link-nav mx-lg-2 {{ request()->is('Program-Keahlian*') ? 'active' : '' }}" href="/login">
                Digital Interest
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link link-nav mx-lg-2 {{ request()->is('presti*') ? 'active' : '' }}" href="{{ route('presti.login') }}">
                <i class="bi bi-clipboard-check me-1"></i> PRESTI
              </a>
            </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
<!-- End Navbar -->

@yield('content')

<!-- Footer -->
{{-- <footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center mb-4">
        <h5 class="text-uppercase fw-bold mb-2">MTS AL ISLAM</h5>
        <p class="mb-1">Jl. Raya Jepara</p>
        <p class="mb-1">(0431) 123456</p>
        <p class="mb-1">info@mtsalislam.sch.id</p>
        <p class="mb-0">&copy; 2025 MTS AL-ISLAM JEPARA. All rights reserved.</p>
      </div>
    </div>

  <!-- Copyright sudah di atas, tidak perlu di sini lagi -->
  </div>
</footer> --}}

<!-- BOOTSTRAP 5 JS -->
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
  crossorigin="anonymous">
</script>

<!-- Sal.js Initialization -->
<script src="{{ asset('assets/js/sal.js') }}"></script>

<!-- Initialize Bootstrap components -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize all Bootstrap popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Fix offcanvas menu click issues using event delegation
    const offcanvas = document.getElementById('offcanvasNavbar');
    if (offcanvas) {
        // Ensure offcanvas is properly initialized
        const offcanvasInstance = new bootstrap.Offcanvas(offcanvas);

        // Use event delegation on the offcanvas body
        const offcanvasBody = offcanvas.querySelector('.offcanvas-body');
        if (offcanvasBody) {
            // Remove any existing event listeners
            offcanvasBody.removeEventListener('click', handleOffcanvasClick);
            // Add event delegation
            offcanvasBody.addEventListener('click', handleOffcanvasClick);
        }

        // Function to handle all clicks within offcanvas
        function handleOffcanvasClick(e) {
            console.log('Click detected in offcanvas!');
            console.log('Target element:', e.target);
            console.log('Target class:', e.target.className);
            console.log('Target tag:', e.target.tagName);

            // Check if clicked element is a nav link or dropdown item
            const navLink = e.target.closest('.nav-link');
            const dropdownItem = e.target.closest('.dropdown-item');

            if (navLink) {
                console.log('Nav link clicked:', navLink.textContent);
                e.preventDefault();
                e.stopPropagation();

                const href = navLink.getAttribute('href');
                console.log('Nav link href:', href);

                if (href && href !== '#') {
                    // Close offcanvas first
                    offcanvasInstance.hide();
                    // Navigate after a short delay
                    setTimeout(function() {
                        console.log('Redirecting to:', href);
                        window.location.href = href;
                    }, 300);
                }
            } else if (dropdownItem) {
                console.log('Dropdown item clicked:', dropdownItem.textContent);
                e.preventDefault();
                e.stopPropagation();

                const href = dropdownItem.getAttribute('href');
                console.log('Dropdown item href:', href);

                if (href && href !== '#') {
                    // Close offcanvas first
                    offcanvasInstance.hide();
                    // Navigate after a short delay
                    setTimeout(function() {
                        console.log('Redirecting to:', href);
                        window.location.href = href;
                    }, 300);
                }
            }
        }
    }
});
</script>

@yield('js')
</body>
</html>
