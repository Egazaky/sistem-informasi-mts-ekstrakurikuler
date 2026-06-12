<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - PRESTI</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3b8b 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            font-family: 'Outfit', sans-serif;
        }

        .login-card {
            border: none;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .login-title {
            font-weight: 700;
            color: #1e3a8a;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border-left: none;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
        }

        .input-group-text {
            border-radius: 12px 0 0 12px;
            background: #f8fafc;
            border-right: none;
            color: #64748b;
        }

        .btn-login {
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            box-shadow: 0 8px 15px rgba(59, 130, 246, 0.4);
            background: linear-gradient(135deg, #172554, #1e3a8a);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center px-3">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">

            <div class="card login-card">
                <div class="card-body p-4 py-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/img/presti-logo.png') }}" alt="PRESTI Logo" height="60" class="mb-3">
                        <h4 class="login-title mb-1">PRESTI</h4>
                        <p class="text-muted small">Sistem Informasi Absensi & SPP</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger text-center small mb-3">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success text-center small mb-3">
                            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('presti.login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" name="username" class="form-control" placeholder="Username / NIS" required autofocus>
                        </div>

                        <div class="input-group mb-4">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-login w-100 text-white mb-3">
                            Masuk
                        </button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <a href="{{ url('/') }}" class="text-decoration-none text-secondary small">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Landing Page
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
