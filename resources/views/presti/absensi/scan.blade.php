@extends('presti.layout')

@section('title', 'Scan Absensi')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary mb-1">Scan Absensi</h3>
    <p class="text-muted">Arahkan QR Code ke kamera atau masukkan data secara manual</p>
</div>

<div class="row g-4">
    <!-- Camera Scanner -->
    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h5 class="fw-bold mb-3 text-secondary">
                <i class="bi bi-qr-code-scan me-1"></i> Scan QR Code
            </h5>
            
            <div class="mb-3">
                <label class="form-label fw-bold text-muted">Jenis Scan</label>
                <select id="jenisScan" class="form-select border-primary shadow-sm" style="border-width: 2px;">
                    <option value="masuk">Absen Masuk</option>
                    <option value="pulang">Absen Pulang</option>
                </select>
            </div>
            
            <div id="reader" class="rounded-3 border overflow-hidden bg-light" style="width:100%"></div>
        </div>
    </div>
    
    <!-- Manual entry -->
    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h5 class="fw-bold mb-3 text-secondary">
                <i class="bi bi-keyboard me-1"></i> Absensi Manual
            </h5>
            <p class="text-muted small">Gunakan apabila kamera bermasalah atau siswa tidak membawa QR Code</p>
            
            <div class="mb-3">
                <label class="form-label fw-semibold">NIS</label>
                <input type="text" id="manualNis" class="form-control rounded-3" placeholder="Masukkan NIS Siswa">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Status Kehadiran</label>
                <select id="manualStatus" class="form-select rounded-3">
                    <option value="">-- Pilih Status --</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Terlambat">Terlambat</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Izin">Izin</option>
                    <option value="Alpha">Alpha</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Catatan / Alasan</label>
                <textarea id="manualCatatan" class="form-control rounded-3" rows="2" placeholder="Tuliskan keterangan alasan..."></textarea>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-semibold">Upload Bukti Foto</label>
                <input type="file" id="manualFoto" class="form-control rounded-3" accept="image/*">
            </div>
            
            <button class="btn btn-primary w-100 py-2 fw-semibold rounded-3" onclick="absenManual()">
                <i class="bi bi-check-circle me-1"></i> Simpan Absensi
            </button>
        </div>
    </div>
</div>

<!-- History Log -->
<div class="card border-0 shadow-sm rounded-4 p-4 mt-4 mb-4">
    <h5 class="fw-bold mb-3 text-secondary">
        <i class="bi bi-list-check me-1"></i> Log Absensi Hari Ini (10 Terakhir)
    </h5>
    <div id="riwayatAbsensi">
        <div class="text-center text-muted py-3">Memuat data absensi...</div>
    </div>
</div>

<!-- MODAL SUCCESS -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-5 rounded-4 border-0">
            <h3 class="text-success mb-3"><i class="bi bi-check-circle-fill display-3"></i></h3>
            <h5 class="fw-bold text-success">Absensi Berhasil</h5>
            <h5 class="fw-semibold mt-3"></h5>
        </div>
    </div>
</div>

<!-- MODAL ERROR -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-5 rounded-4 border-0">
            <h3 class="text-danger mb-3"><i class="bi bi-x-circle-fill display-3"></i></h3>
            <h5 class="fw-bold text-danger">Gagal Mencatat Absensi</h5>
            <h5 id="errorText" class="fw-semibold mt-3 text-muted"></h5>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function playSuccessBeep() {
        try {
            const Ctx = window.AudioContext || window.webkitAudioContext;
            if(!Ctx) return;
            const audioCtx = new Ctx();
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();
            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(800, audioCtx.currentTime);
            oscillator.frequency.exponentialRampToValueAtTime(1200, audioCtx.currentTime + 0.1);
            gainNode.gain.setValueAtTime(0.2, audioCtx.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.15);
            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);
            oscillator.start();
            oscillator.stop(audioCtx.currentTime + 0.15);
        } catch(e) {}
    }

    function playErrorBeep() {
        try {
            const Ctx = window.AudioContext || window.webkitAudioContext;
            if(!Ctx) return;
            const audioCtx = new Ctx();
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();
            oscillator.type = 'sawtooth';
            oscillator.frequency.setValueAtTime(300, audioCtx.currentTime);
            oscillator.frequency.exponentialRampToValueAtTime(150, audioCtx.currentTime + 0.3);
            gainNode.gain.setValueAtTime(0.2, audioCtx.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);
            oscillator.start();
            oscillator.stop(audioCtx.currentTime + 0.3);
        } catch(e) {}
    }

    let isScanning = true;
    let scanStartTime = 0;

    function loadRiwayat() {
        fetch("{{ route('presti.absensi.riwayat') }}")
        .then(res => res.text())
        .then(html => {
            document.getElementById('riwayatAbsensi').innerHTML = html;
        });
    }
    
    document.addEventListener("DOMContentLoaded", loadRiwayat);

    function onScanSuccess(decodedText){
        if(!isScanning) return;
        isScanning = false;
        scanStartTime = Date.now();
        submitAbsensi(decodedText);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: 250 }
    );
    html5QrcodeScanner.render(onScanSuccess);

    function absenManual(){
        const nis = document.getElementById("manualNis").value;
        const status = document.getElementById("manualStatus").value;
        const catatan = document.getElementById("manualCatatan").value;
        const foto = document.getElementById("manualFoto").files[0];

        if(nis === ""){
            showError("NIS tidak boleh kosong");
            return;
        }

        submitAbsensi(nis, status === "" ? null : status, catatan, foto);
    }

    function submitAbsensi(nis, status=null, catatan="", foto=null){
        let jenisScan = document.getElementById('jenisScan').value;
        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('nis', nis);
        formData.append('jenis_scan', jenisScan);
        if(status !== null) formData.append('status', status);
        if(catatan !== "") formData.append('catatan', catatan);
        if(foto !== undefined && foto !== null) formData.append('bukti_foto', foto);

        fetch("{{ route('presti.absensi.scan') }}", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === "success"){
                document.querySelector("#successModal h5:last-child").innerHTML = data.nama + " (" + data.status_hadir + ")<br><small class='text-muted'>" + data.jam + "</small>";
                showModal("successModal", 1200);
                playSuccessBeep();
                loadRiwayat();
                
                // Clear manual fields
                document.getElementById("manualNis").value = "";
                document.getElementById("manualStatus").value = "";
                document.getElementById("manualCatatan").value = "";
                document.getElementById("manualFoto").value = "";
                
                setTimeout(()=>isScanning=true, 1200);
            }else{
                showError(data.message);
                playErrorBeep();
                setTimeout(()=>isScanning=true, 2500);
            }
        })
        .catch(()=>{
            showError("Terjadi kesalahan sistem");
            playErrorBeep();
            setTimeout(()=>isScanning=true, 2500);
        });
    }

    function showModal(id, autoCloseMs = 0){
        let el = document.getElementById(id);
        let modal = bootstrap.Modal.getInstance(el);
        if(!modal) modal = new bootstrap.Modal(el);
        modal.show();
        
        if(autoCloseMs > 0) {
            setTimeout(() => { modal.hide(); }, autoCloseMs);
        }
    }

    function showError(msg){
        document.getElementById("errorText").innerText = msg;
        showModal("errorModal");
    }
</script>
@endsection
