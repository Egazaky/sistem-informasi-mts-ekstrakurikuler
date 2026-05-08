@extends('admin/template')
@section('content')
<div class="page-wrapper">
    @php
        function nilaiCrips($nilai){
            switch (true) {
            case ($nilai <= 30):
                return 1;
                break;
            case ($nilai <= 60):
                return 2;
                break;
            case ($nilai <= 80):
                return 3;
                break;
            case ($nilai > 80):
                return 4;
                break;
            }
        }
        for ($i=1; $i <= count($kriteria); $i++) {
            $kri[$i] = [];
        }
    @endphp
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Proses Analisis</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Proses Analisis</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Alternatif</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ekstrakulikuler</th>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($kriteria as $item)
                                            <th>C{{$no++;}}-{{$item->nama_kriteria}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ekstra as $e)
                                    <tr>
                                        <td>{{$e->nama_ekstra}}</td>
                                        @foreach ($kriteria as $k)
                                            @foreach ($alternatif as $a)
                                                @if ($e->id == $a->ekstra_id &&  $k->id == $a->kriteria_id)
                                                    <td>{{$a->nilai}}</td>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <h4 style="color: red"> Metode Fuzzy MADM</h4>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pembobotan ( Matrik Keputusan )</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ekstrakulikuler</th>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($kriteria as $item)
                                            <th>C{{$no++;}}-{{$item->nama_kriteria}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ekstra as $e)
                                    <tr>
                                        <td>{{$e->nama_ekstra}}</td>
                                        @foreach ($kriteria as $k)
                                            @foreach ($alternatif as $a)
                                                @if ($e->id == $a->ekstra_id &&  $k->id == $a->kriteria_id)
                                                    @php
                                                        array_push($kri[$k->id], nilaiCrips($a->nilai));
                                                    @endphp
                                                    <td>{{nilaiCrips($a->nilai)}}</td>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                 <h4 style="color: red"> Metode Simple Additive Weighting (SAW)</h4>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Normalisasi</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ekstrakulikuler</th>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($kriteria as $item)
                                            <th>C{{$no++;}}-{{$item->nama_kriteria}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ekstra as $e)
                                    <tr>
                                        <td>{{$e->nama_ekstra}}</td>
                                        @foreach ($kriteria as $k)
                                            @foreach ($alternatif as $a)
                                                @if ($e->id == $a->ekstra_id &&  $k->id == $a->kriteria_id)
                                                    <td>{{nilaiCrips($a->nilai)/max($kri[$k->id])}}</td>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Perangkingan</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ekstrakulikuler</th>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($kriteria as $item)
                                            <th>C{{$no++;}}-{{$item->nama_kriteria}}</th>
                                        @endforeach
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ekstra as $e)
                                    <tr>
                                            @php
                                                $jum=0;
                                            @endphp
                                        <td>{{$e->nama_ekstra}}</td>
                                        @foreach ($kriteria as $k)
                                            @foreach ($alternatif as $a)
                                                @if ($e->id == $a->ekstra_id &&  $k->id == $a->kriteria_id)
                                                    @php
                                                        $jum = (nilaiCrips($a->nilai)/max($kri[$k->id]))*$k->bobot+$jum;
                                                    @endphp
                                                    <td>{{(nilaiCrips($a->nilai)/max($kri[$k->id]))*$k->bobot}}</td>
                                                @endif
                                            @endforeach
                                        @endforeach
                                            <td>{{$jum}}</td>
                                            @php
                                                    $jum=0;
                                            @endphp

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Hasil Perangkingan</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Rangking</th>
                                        <th>Ekstrakulikuler</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($hasil_saw as $item)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$item->ekstra->nama_ekstra}}</td>
                                        <td>{{round($item->total,2)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <h4 style="color: red"> Hasil : </h4>
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px">
                            hasil perhitungan Metode Fuzzy MADM dan Simple Additive Weighting (SAW) mendapat nilai <b>{{round($hasil_saw[0]->total,0)}}</b> yaitu Ekstrakulikuler <b>{{$hasil_saw[0]->ekstra->nama_ekstra}}</b></b>.
                        </p>
                    </div>
                </div>

        </div>
</div>
@endsection
