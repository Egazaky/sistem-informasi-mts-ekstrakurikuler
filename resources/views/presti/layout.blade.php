<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PRESTI</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts (Outfit) -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/presti.css') }}?v={{ time() }}">
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }
        .navbar {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar {
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
            height: calc(100vh - 56px);
            position: fixed;
            top: 56px;
            left: 0;
            width: 250px;
            padding-top: 1.5rem;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
            margin-bottom: 0.25rem;
        }
        .sidebar a:hover {
            color: #3b82f6;
            background-color: #f1f5f9;
        }
        .sidebar a.active {
            color: #3b82f6;
            background-color: #eff6ff;
            border-left-color: #3b82f6;
        }
        .sidebar a i {
            font-size: 1.25rem;
            margin-right: 0.75rem;
        }
        .content {
            margin-left: 250px;
            padding: 2rem;
            margin-top: 56px;
            min-height: calc(100vh - 56px);
            transition: all 0.3s ease;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 56px;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 999;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .sidebar-overlay.show {
                display: block;
            }
            .content {
                margin-left: 0;
                padding: 1rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm no-print">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-outline-light d-md-none me-2 px-2 py-1" id="sidebarToggle" style="border:none;">
                    <i class="bi bi-list fs-3"></i>
                </button>
                <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/presti') }}">
                    <img src="{{ asset('assets/img/presti-logo.png') }}" alt="Logo" height="30" class="me-2">
                    <span>PRESTI</span>
                </a>
            </div>
            <div class="text-white d-none d-sm-block">
                <small class="opacity-75">Login sebagai: </small>
                <span class="fw-semibold">{{ session('presti_username', 'User') }}</span>
                <span class="badge bg-white text-primary ms-1 text-uppercase">{{ session('presti_role') }}</span>
            </div>
        </div>
    </nav>

    <!-- SIDEBAR -->
    <div class="sidebar d-flex flex-column no-print">
        @php
            $role = session('presti_role');
            $currentPath = request()->getPathInfo();
        @endphp

        @if($role === 'admin')
            <a href="{{ route('presti.dashboard.admin') }}" class="{{ str_starts_with($currentPath, '/presti/dashboard/admin') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('presti.siswa.index') }}" class="{{ str_starts_with($currentPath, '/presti/siswa') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Kelola Siswa
            </a>
            <a href="{{ route('presti.absensi.scan') }}" class="{{ str_starts_with($currentPath, '/presti/absensi/scan') ? 'active' : '' }}">
                <i class="bi bi-qr-code-scan"></i> Scan Absensi
            </a>
            <a href="{{ route('presti.tagihan.manage') }}" class="{{ str_starts_with($currentPath, '/presti/tagihan') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i> Tagihan Keuangan
            </a>
            <a href="{{ route('presti.analisis.kelas') }}" class="{{ str_starts_with($currentPath, '/presti/analisis') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Analisis Kelas
            </a>
            <a href="{{ route('presti.absensi.export') }}" class="{{ str_starts_with($currentPath, '/presti/absensi/export') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="{{ route('presti.absensi.cetak-qr') }}" class="{{ str_starts_with($currentPath, '/presti/absensi/cetak-qr') ? 'active' : '' }}">
                <i class="bi bi-qr-code"></i> Cetak QR Siswa
            </a>
        @elseif($role === 'guru')
            <a href="{{ route('presti.dashboard.guru') }}" class="{{ str_starts_with($currentPath, '/presti/dashboard/guru') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('presti.absensi.scan') }}" class="{{ str_starts_with($currentPath, '/presti/absensi/scan') ? 'active' : '' }}">
                <i class="bi bi-qr-code-scan"></i> Scan Absensi
            </a>
            <a href="{{ route('presti.analisis.kelas') }}" class="{{ str_starts_with($currentPath, '/presti/analisis') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Analisis Kelas
            </a>
            <a href="{{ route('presti.absensi.export') }}" class="{{ str_starts_with($currentPath, '/presti/absensi/export') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
        @elseif($role === 'siswa')
            <a href="{{ route('presti.dashboard.siswa') }}" class="{{ str_starts_with($currentPath, '/presti/dashboard/siswa') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('presti.qr-siswa') }}" class="{{ str_starts_with($currentPath, '/presti/qr-siswa') ? 'active' : '' }}">
                <i class="bi bi-qr-code"></i> QR Code Absensi
            </a>
            <a href="{{ route('presti.tagihan.siswa') }}" class="{{ str_starts_with($currentPath, '/presti/tagihan') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i> Tagihan Keuangan
            </a>
            <a href="{{ route('presti.password') }}" class="{{ str_starts_with($currentPath, '/presti/password') ? 'active' : '' }}">
                <i class="bi bi-key"></i> Ganti Password
            </a>
        @elseif($role === 'ortu')
            <a href="{{ route('presti.dashboard.ortu') }}" class="{{ str_starts_with($currentPath, '/presti/dashboard/ortu') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('presti.tagihan.ortu') }}" class="{{ str_starts_with($currentPath, '/presti/tagihan') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i> Tagihan Keuangan
            </a>
        @endif

        <div class="mt-auto mb-3 px-3">
            <a href="{{ route('presti.logout') }}" onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?');" class="text-danger fw-bold d-flex align-items-center p-2 text-decoration-none rounded hover-bg-danger-light" style="transition:0.2s;">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <main class="content">
        @yield('content')
    </main>

    <!-- OVERLAY FOR MOBILE -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggleBtn = document.getElementById('sidebarToggle');
            var sidebar = document.querySelector('.sidebar');
            var overlay = document.getElementById('sidebarOverlay');
            if(toggleBtn && sidebar && overlay) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                });
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
