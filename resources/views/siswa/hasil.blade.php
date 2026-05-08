@extends('siswa.template')
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Hasil Rekomendasi Ekstrakurikuler</h4>
                <div class="alert alert-info">
                    <b>Kecerdasan Dominan (Bakat):</b> {{ $kecerdasan_dominan }}<br>
                    <b>Bidang Minat yang Relevan:</b> {{ $minat_objek ?? '-' }}<br>
                    <b>Rekomendasi Ekstrakurikuler:</b> {{ $rekomendasi }}<br>
                    <b>Total Skor Bakat:</b> {{ $bakat }}<br>
                    <b>Total Skor Minat:</b> {{ $minat }}<br>
                </div>
                <a href="{{ route('minat-bakat') }}?ulang=1" class="btn btn-primary">Isi Ulang Kuesioner</a>
            </div>
        </div>
    </div>
</div>
@endsection
