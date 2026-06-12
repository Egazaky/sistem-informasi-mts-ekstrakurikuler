@extends('presti.layout')

@section('title', 'Cetak QR Code Siswa')

@section('styles')
<style>
    .qr-card {
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .qr-card:hover {
        border-color: #3b82f6;
    }
    .qr-box {
        width: 100%;
        max-width: 160px;
        aspect-ratio: 1;
        margin: auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .qr-box img, .qr-box canvas {
        max-width: 100% !important;
        height: auto !important;
    }

    @media print {
        @page { margin: 1cm; }
        body { background: #fff; color: #000; }
        .no-print { display:none !important; }
        .sidebar, .navbar { display:none !important; }
        
        .content { 
            margin-left: 0 !important;
            padding: 0 !important; 
            margin-top: 0 !important;
            width: 100% !important;
            min-height: auto !important;
        }
        
        .qr-card {
            box-shadow: none !important;
            border: 2px solid #000 !important;
            border-radius: 8px !important;
            page-break-inside: avoid;
            padding: 15px 10px !important;
        }
        
        .qr-col {
            flex: 0 0 25% !important;
            max-width: 25% !important;
            padding: 10px !important;
        }
        
        .badge {
            border: 1px solid #000 !important;
            color: #000 !important;
            background: transparent !important;
        }
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 no-print">
    <div>
        <h3 class="fw-bold text-primary mb-1">Cetak QR Code Siswa</h3>
        <p class="text-muted mb-0">Cetak kartu QR Code untuk keperluan scanner absensi siswa</p>
    </div>
    
    <button onclick="window.print()" class="btn btn-primary fw-semibold px-4 rounded-3">
        <i class="bi bi-printer me-1"></i> Cetak QR Codes
    </button>
</div>

<!-- Filter Kelas -->
<div class="card border-0 shadow-sm rounded-4 mb-4 no-print">
    <div class="card-body">
        <form method="GET" action="{{ route('presti.absensi.cetak-qr') }}" class="row g-3">
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold text-muted">Filter Kelas</label>
                <select name="kelas" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelas_list as $kls)
                        <option value="{{ $kls }}" {{ $kelas_id == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

<!-- Grid QR Code -->
<div class="row g-3">
    @forelse($siswa as $s)
        <div class="col-6 col-sm-4 col-md-3 col-xl-2 qr-col">
            <div class="card qr-card rounded-4 p-3 text-center h-100 bg-white shadow-sm">
                <div class="qr-box mb-3" id="qr{{ $s->id }}"></div>
                <h6 class="fw-bold mb-1 text-dark text-truncate">{{ $s->nama }}</h6>
                <small class="text-muted d-block mb-2">{{ $s->kelas }}</small>
                <span class="badge bg-light text-dark border w-100 py-2 fs-6">
                    NIS: {{ $s->nis }}
                </span>
            </div>
        </div>
        
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                new QRCode(document.getElementById("qr{{ $s->id }}"), {
                    text: "{{ $s->nis }}",
                    width: 160,
                    height: 160,
                    colorDark : "#000000",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H
                });
            });
        </script>
    @empty
        <div class="col-12 text-center text-muted py-5 no-print">
            <i class="bi bi-people fs-1 d-block mb-3"></i>
            Data siswa tidak ditemukan.
        </div>
    @endforelse
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
@endsection
