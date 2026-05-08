@extends('siswa/template')
@section('content')
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Profil</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profil</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="card">
                    <div class="card">
                        <form action="{{ route('update_siswa_username') }}">
                            @csrf
                            <div class="card-body">
                                <h5 class="card-title">Ubah Username</h5>
                                @if (session()->has('status_ket'))
                                    @if (session()->get('status_ket') == '1')
                                        <div class="alert alert-primary" role="alert">
                                            Berhasil
                                        </div>
                                    @else
                                        <div class="alert alert-danger" role="alert">
                                            {{session()->get('status_ket')}}
                                        </div>
                                    @endif
                                    
                                @endif
                                <input type="hidden" name="id" value="{{$siswa[0]->id}}">
                                <input type="hidden" name="user_old" value="{{$siswa[0]->username}}">
                                    <div class="form-group row">
                                        <label for="nama"
                                            class="col-sm-3 text-end control-label col-form-label">Username</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"  id="nama" value="{{$siswa[0]->username}}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama"
                                            class="col-sm-3 text-end control-label col-form-label">Username Baru</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="user_new" id="nama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama"
                                            class="col-sm-3 text-end control-label col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="password" id="nama">
                                        </div>
                                    </div>
                                    
                            </div>
                            <div class="border-top">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                </div>
                            </div>
                            </form>
                    </div>
                </div>
                 <div class="card">
                    <div class="card">
                         <form action="{{ route('update_siswa_password') }}">
                            @csrf
                            <div class="card-body">
                                <h5 class="card-title">Ubah Password</h5>
                                @if (session()->has('status_ket_p'))
                                    @if (session()->get('status_ket_p') == '1')
                                        <div class="alert alert-primary" role="alert">
                                            Berhasil
                                        </div>
                                    @else
                                        <div class="alert alert-danger" role="alert">
                                            {{session()->get('status_ket_p')}}
                                        </div>
                                    @endif
                                    
                                @endif
                                 <input type="hidden" name="id" value="{{$siswa[0]->id}}">
                                    <div class="form-group row">
                                        <label for="nama"
                                            class="col-sm-3 text-end control-label col-form-label">Password baru</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="password_baru" id="nama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama"
                                            class="col-sm-3 text-end control-label col-form-label">Password lama</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="password_lama" id="nama">
                                        </div>
                                    </div>
                            </div>
                            <div class="border-top">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                </div>
                            </div>
                         </form>
                    </div>
                </div>
</div>
@endsection