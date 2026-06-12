@extends('presti.layout')

@section('title', 'Ganti Password Siswa')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary mb-1"><i class="bi bi-key"></i> Ganti Password</h3>
    <p class="text-muted">Ganti sandi login demi keamanan akun Anda</p>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert">
                    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('presti.password.update') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Password Lama</label>
                    <input type="password" name="password_lama" class="form-control rounded-3" required placeholder="Masukkan password saat ini">
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Password Baru</label>
                    <input type="password" name="password_baru" class="form-control rounded-3" required minlength="4" placeholder="Minimal 4 karakter">
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi_password" class="form-control rounded-3" required minlength="4" placeholder="Ulangi password baru">
                </div>
                
                <button type="submit" class="btn btn-warning w-100 fw-bold py-2 rounded-3 text-dark">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan Password
                </button>
            </form>
        </div>
        
        <div class="alert alert-info mt-3 border-0 shadow-sm rounded-4 bg-white p-3">
            <div class="d-flex gap-2">
                <i class="bi bi-info-circle fs-5 text-info"></i>
                <div>
                    <strong class="d-block mb-1">Tips Keamanan:</strong>
                    <span class="small text-muted d-block">Jangan gunakan password default yang sama dengan NIS. Buat sandi baru yang hanya Anda ketahui.</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
