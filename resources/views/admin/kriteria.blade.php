@extends('admin/template')
@section('content')
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Data Kriteria</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data Kriteria</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                    <div class="ms-auto text-end" style="margin-top: 10px;">
                    <a href="{{URL::route('tambah-kriteria')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> tambah data</a>
                </div>
            </div>
            <div class="container-fluid">
                @if ($aksi == 'tampil')
                <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Tabel Kriteria</h5>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kriteria</th>
                                                <th>Bobot</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no=1;
                                            @endphp
                                            @foreach ($kriteria as $item)
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>{{$item->nama_kriteria}}</td>
                                                <td>{{$item->bobot}}</td>
                                                <td>
                                                    <a href="{{ route('hapus-kriteria', ['id'=>$item->id]) }}" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        {{-- <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kriteria</th>
                                                <th>Bobot</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot> --}}
                                    </table>
                                </div>

                            </div>
                        </div>
                        @else

                        <div class="card">
                            <form method="post" action="{{URL::route('proses-tambah-kriteria')}}">
                            @csrf
                                <div class="card-body">
                                    <h5 class="card-title">Form</h5>
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Nama Kriteria</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="nama" id="nama">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="bobot"
                                                class="col-sm-3 text-end control-label col-form-label">Bobot</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="bobot" id="bobot">
                                            </div>
                                        </div>
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{URL::route('data-kriteria')}}" class="btn btn-secondary">Batal</a>
                                    </div>
                                </div>
                                </form>
                        </div>
                        @endif
                    </div>
</div>
@endsection
