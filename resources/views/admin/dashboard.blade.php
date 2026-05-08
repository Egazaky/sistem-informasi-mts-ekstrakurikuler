@extends('admin/template')
@section('content')
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Dashboard</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <div class="row">
                    <!-- Column -->
                    {{-- <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                                <h6 class="text-white">Dashboard</h6>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <a href="{{ route('data-siswa')}}" style="text-decoration: none;">
                        <div class="card card-hover">
                            <div class="box bg-warning text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-chart-bar"></i></h1>
                                <h6 class="text-white">Data Siswa</h6>
                            </div>
                        </div>
                        </a>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                    <a href="{{ route('data-ekstra')}}" style="text-decoration: none;">
                        <div class="card card-hover">
                            <div class="box bg-danger text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-chart-bubble"></i></h1>
                                <h6 class="text-white">Ekstrakurikuler</h6>
                            </div>
                        </div>
                        </a>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <a href="{{ route('guru.index')}}" style="text-decoration: none;">
                        <div class="card card-hover">
                            <div class="box bg-success text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-account-multiple"></i></h1>
                                <h6 class="text-white">Data Guru</h6>
                            </div>
                        </div>
                        </a>
                    </div>
                    <!-- Column -->
                    {{-- <div class="col-md-6 col-lg-2 col-xlg-3">
                    <a href="{{ route('data-kriteria')}}" style="text-decoration: none;">
                        <div class="card card-hover">
                            <div class="box bg-info text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-note-outline"></i></h1>
                                <h6 class="text-white">Kriteria</h6>
                            </div>
                        </div>
                        </a>
                    </div> --}}
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <a href="{{ route('pertanyaan')}}" style="text-decoration: none;">
                        <div class="card card-hover">
                            <div class="box bg-info text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-note-plus"></i></h1>
                                <h6 class="text-white">Pertanyaan</h6>
                            </div>
                        </div>
                        </a>
                    </div>
                    <!-- Column -->
                    {{-- <div class="col-md-6 col-lg-2 col-xlg-3">
                        <a href="{{ route('proses')}}" style="text-decoration: none;">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-receipt"></i></h1>
                                <h6 class="text-white">Proses Analisis</h6>
                            </div>
                        </div>
                        </a>
                    </div> --}}
                    <!-- Column -->
                </div>
                <!-- accoridan part -->
                        <div class="accordion" id="accordionExample">
                            <div class="card mb-0">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            <i class="me-1 fa fa-magnet" aria-hidden="true"></i>
                                            <span>Metode Analisis</span>
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                    Berdasarkan Pedoman Penelusuran Minat dan Bakat Jenjang SMP (Peraturan Menteri Pendidikan dan Kebudayaan Republik Indonesia Nomor 111 Tahun 2014 Tentang Bimbingan dan Konseling pada Pendidikan Dasar dan Pendidikan Menengah mendorong layanan Pendidikan yang lebih komprehensif).
                                    Penentuan minat dan bakat dilakukan melalui pengisian angket/kuesioner, analisis potensi diri, dan pemetaan kecenderungan siswa. Hasil analisis digunakan untuk memberikan rekomendasi ekstrakurikuler dan pengembangan diri siswa secara optimal.
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
@endsection
