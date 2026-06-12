@extends('presti.layout')

@section('title', 'QR Code Absensi')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary mb-1"><i class="bi bi-qr-code"></i> QR Code Absensi</h3>
    <p class="text-muted">Gunakan kartu QR Code ini untuk scan masuk & pulang di sekolah</p>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 text-center p-4 bg-white">
            <div class="card-body">
                <span class="text-muted small fw-semibold text-uppercase d-block mb-3">Kartu Absensi Digital</span>
                
                <div id="qrcode" class="d-inline-block p-3 border rounded-4 bg-white mb-4 shadow-sm"></div>
                
                <h4 class="fw-bold text-dark mb-1">{{ $siswa->nama }}</h4>
                <p class="text-muted small mb-0">Kelas: {{ $siswa->kelas }}</p>
                <div class="badge bg-light text-dark border mt-2 px-3 py-2 fs-6 rounded-pill">
                    NIS: {{ $siswa->nis }}
                </div>
                
                <button class="btn btn-primary w-100 py-2 fw-semibold rounded-3 mt-4" onclick="downloadQR()">
                    <i class="bi bi-download me-2"></i> Download QR Code
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ $siswa->nis }}",
            width: 200,
            height: 200,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    });

    function downloadQR() {
        const qrCanvas = document.querySelector("#qrcode canvas");
        if (qrCanvas) {
            const tempLink = document.createElement("a");
            tempLink.download = "QR_{{ $siswa->nis }}.png";
            tempLink.href = qrCanvas.toDataURL("image/png");
            tempLink.click();
        } else {
            alert("Gambar QR Code belum termuat dengan sempurna.");
        }
    }
</script>
@endsection
