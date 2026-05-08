@extends('admin/template')
@section('content')
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Data Ekstrakurikuler</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data Ekstrakurikuler</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="ms-auto text-end" style="margin-top: 10px;">
                    <a href="{{URL::route('tambah-ekstra')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> tambah data</a>
                </div>
            </div>
            <div class="container-fluid">
                @if ($aksi == 'tampil')
                <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Tabel Ekstrakurikuler</h5>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Gambar</th>
                                                <th>Ekstrakurikuler</th>
                                                <th>Kategori</th>
                                                <th>Objek Pilihan</th>
                                                <th>Deskripsi</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no=1;
                                            @endphp
                                            @foreach ($ekstra as $item)
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>
                                                    @if(empty($item->gambar))
                                                        <span class="text-muted">Tidak ada gambar</span>
                                                    @else
                                                        <img class="control-label" src="{{ asset('storage/images/'.$item->gambar) }}" style="margin-bottom:10px; width: 100px;" alt="Gambar tidak ditemukan" onerror="this.onerror=null;this.src='https://via.placeholder.com/100x100?text=No+Image';">
                                                    @endif
                                                </td>
                                                <td>{{$item->nama_ekstra}}</td>
                                                <td>{{$item->kategori ?? '-'}}</td>
                                                <td>{{$item->objek_pilihan ?? $item->bakat}}</td>
                                                <td>{{$item->deskripsi}}</td>
                                                <td>
                                                    <a href="{{ route('edit-ekstra', ['id'=>$item->id]) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('hapus-ekstra', ['id'=>$item->id]) }}" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        {{-- <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Ekstrakulikuler</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot> --}}
                                    </table>
                                </div>

                            </div>
                        </div>
                        @elseif($aksi == 'tambah')

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card">
                            <form method="post" action="{{URL::route('proses-tambah-ekstra')}}" enctype="multipart/form-data">
                                @csrf

                                <div class="card-body">
                                    <h5 class="card-title">Form Tambah</h5>
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Nama Ekstra</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="nama" id="nama">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Deskripsi</label>
                                            <div class="col-sm-9">
                                                <textarea name="deskripsi" class="form-control" id="" cols="3" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kategori" class="col-sm-3 text-end control-label col-form-label">Kategori</label>
                                            <div class="col-sm-9">
                                                <select name="kategori" id="kategori" class="form-control" required>
                                                    <option value="minat" {{ (isset($ekstra[0]) && $ekstra[0]->kategori == 'minat') ? 'selected' : '' }}>{{ isset($ekstra[0]) && $ekstra[0]->kategori == 'minat' ? 'Minat' : 'Minat' }}</option>
                                                    <option value="bakat" {{ (isset($ekstra[0]) && $ekstra[0]->kategori == 'bakat') ? 'selected' : '' }}>{{ isset($ekstra[0]) && $ekstra[0]->kategori == 'bakat' ? 'Bakat' : 'Bakat' }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="objek_pilihan" class="col-sm-3 text-end control-label col-form-label">Objek Pilihan</label>
                                            <div class="col-sm-9">
                                                <select name="objek_pilihan" id="objek_pilihan" class="form-control" required>
                                                    <!-- opsi akan diisi oleh JS -->
                                                </select>
                                                <input type="hidden" id="objek_pilihan_value" value="{{ isset($ekstra[0]) ? $ekstra[0]->objek_pilihan : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Hari</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="jadwal_hari" id="">
                                                    <option value="Senin">Senin</option>
                                                    <option value="Selasa">Selasa</option>
                                                    <option value="Rabu">Rabu</option>
                                                    <option value="Kamis">Kamis</option>
                                                    <option value="Jumat">Jumat</option>
                                                    <option value="Sabtu">Sabtu</option>
                                                    <option value="Minggu">Minggu</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Jam</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="jadwal_jam" id="nama" placeholder="12:00 - 13:00">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Nama Guru</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="nm_guru" id="nama">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Gambar</label>

                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" name="gambar" id="nama" placeholder="12:00 - 13:00">
                                            </div>
                                        </div>
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{URL::route('data-ekstra')}}" class="btn btn-secondary">Batal</a>
                                    </div>
                                </div>
                                </form>
                        </div>
                        @else
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card">
                            <form method="post" action="{{URL::route('proses-edit-ekstra')}}" enctype="multipart/form-data">
                                @csrf

                                <div class="card-body">
                                    <h5 class="card-title">Form Edit</h5>
                                     <input type="hidden" class="form-control" value="{{$ekstra[0]->id}}" name="id" id="id">
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Nama Ekstra</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{$ekstra[0]->nama_ekstra}}" name="nama" id="nama">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Deskripsi</label>
                                            <div class="col-sm-9">
                                                <textarea name="deskripsi" class="form-control" id="" cols="3" rows="3">{{$ekstra[0]->deskripsi}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kategori" class="col-sm-3 text-end control-label col-form-label">Kategori</label>
                                            <div class="col-sm-9">
                                                <select name="kategori" id="kategori" class="form-control" required>
                                                    <option value="minat" {{ (isset($ekstra[0]) && $ekstra[0]->kategori == 'minat') ? 'selected' : '' }}>Minat</option>
                                                    <option value="bakat" {{ (isset($ekstra[0]) && $ekstra[0]->kategori == 'bakat') ? 'selected' : '' }}>Bakat</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="objek_pilihan" class="col-sm-3 text-end control-label col-form-label">Objek Pilihan</label>
                                            <div class="col-sm-9">
                                                <select name="objek_pilihan" id="objek_pilihan" class="form-control" required>
                                                    <!-- opsi akan diisi oleh JS -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Hari</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="jadwal_hari">
                                                    <option {{ $ekstra[0]->jadwal_hari == 'Senin' ? 'selected':'' }} value="Senin">Senin</option>
                                                    <option {{ $ekstra[0]->jadwal_hari == 'Selasa' ? 'selected':'' }} value="Selasa">Selasa</option>
                                                    <option {{ $ekstra[0]->jadwal_hari == 'Rabu' ? 'selected':'' }} value="Rabu">Rabu</option>
                                                    <option {{ $ekstra[0]->jadwal_hari == 'Kamis' ? 'selected':'' }} value="Kamis">Kamis</option>
                                                    <option {{ $ekstra[0]->jadwal_hari == 'Jumat' ? 'selected':'' }} value="Jumat">Jumat</option>
                                                    <option {{ $ekstra[0]->jadwal_hari == 'Sabtu' ? 'selected':'' }} value="Sabtu">Sabtu</option>
                                                    <option {{ $ekstra[0]->jadwal_hari == 'Minggu' ? 'selected':'' }} value="Minggu">Minggu</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Jam</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{$ekstra[0]->jadwal_jam}}" name="jadwal_jam" id="nama" placeholder="12:00 - 13:00">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Nama Guru</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{$ekstra[0]->nm_guru}}" name="nm_guru" id="nama">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama"
                                                class="col-sm-3 text-end control-label col-form-label">Gambar</label>
                                            <div class="col-sm-9">
                                                <input type="hidden" name="gambar_lama" value="storage/images/{{$ekstra[0]->gambar}}">
                                                <img class="control-label" src="{{ asset('storage/images/'.$ekstra[0]->gambar) }}" style="margin-bottom:10px; 100px; width: 100px;" alt="">
                                                <input type="file" class="form-control" name="gambar" id="nama" placeholder="12:00 - 13:00">
                                            </div>
                                        </div>
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{URL::route('data-ekstra')}}" class="btn btn-secondary">Batal</a>
                                    </div>
                                </div>
                                </form>
                        </div>
                        @endif
                    </div>
</div>
@endsection
@push('scripts')
<script>
const minatOptions = [
    'Keagamaan',
    'Matematika',
    'Ilmu Pengetahuan Alam',
    'Ilmu Pengetahuan Sosial',
    'Bahasa dan Budaya',
    'Teknologi dan Rekayasa',
    'Teknologi Informasi dan Komunikasi',
    'Kesehatan',
    'Agrobisnis dan Agroteknologi',
    'Perikanan dan Kelautan',
    'Bisnis dan Manajemen',
    'Pariwisata',
    'Seni dan Kerajinan',
    'Keolahragaan'
];
const bakatOptions = [
    'Linguistik', 'Logika-Matematika', 'Visual-Spasial', 'Musikal', 'Kinestetik', 'Interpersonal', 'Intrapersonal', 'Naturalis'
];
function setObjekPilihan(selected = null) {
    const kategori = document.getElementById('kategori');
    const select = document.getElementById('objek_pilihan');
    if (!kategori || !select) return;
    let options = kategori.value === 'bakat' ? bakatOptions : minatOptions;
    select.innerHTML = '';
    options.forEach(opt => {
        let option = document.createElement('option');
        option.value = opt;
        option.text = opt;
        if (selected && selected === opt) option.selected = true;
        select.appendChild(option);
    });
}
document.addEventListener('DOMContentLoaded', function() {
    const kategori = document.getElementById('kategori');
    const objekPilihan = document.getElementById('objek_pilihan');
    const objekPilihanValue = document.getElementById('objek_pilihan_value');
    if (kategori && objekPilihan) {
        setObjekPilihan(objekPilihanValue ? objekPilihanValue.value : null);
        kategori.addEventListener('change', function() {
            setObjekPilihan();
        });
    }
});
</script>
@endpush
