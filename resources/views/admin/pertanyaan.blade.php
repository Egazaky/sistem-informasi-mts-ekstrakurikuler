@extends('admin/template')
@section('content')
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Data Pertanyaan</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data Pertanyaan</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="ms-auto text-end" style="margin-top: 10px;">
                    <a href="{{URL::route('tambah-pertanyaan')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> tambah data</a>
                </div>
            </div>
            <div class="container-fluid">
                @if ($aksi == 'tampil')
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tabel Pertanyaan Minat & Bakat</h5>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">No</th>
                                        <th style="width:120px;">Objek Pilihan</th>
                                        <th>Pernyataan</th>
                                        <th style="width:90px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no=1; @endphp
                                    @foreach ($pertanyaan as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->objek_pilihan }}</td>
                                        <td>{{ $item->pernyataan }}</td>
                                        <td>
                                            <a href="{{ route('ubah-pertanyaan', ['id'=>$item->id]) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('hapus-pertanyaan', ['id'=>$item->id]) }}" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @elseif($aksi == 'tambah')

                <div class="card">
                    <form method="post" action="{{URL::route('proses-tambah-pertanyaan')}}">
                        @csrf
                        <div class="card-body">
                            <h5 class="card-title">Form Tambah Pertanyaan Minat & Bakat</h5>
                            <div class="form-group row">
                                <label for="kategori" class="col-sm-3 text-end control-label col-form-label">Kategori</label>
                                <div class="col-sm-9">
                                    <select name="kategori" id="kategori" class="form-control" required>
                                        <option value="minat">Minat</option>
                                        <option value="bakat">Bakat</option>
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
                                <label for="pernyataan" class="col-sm-3 text-end control-label col-form-label">Pernyataan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="pernyataan" id="pernyataan" required>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{URL::route('pertanyaan')}}" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <div class="card">
                    <form method="post" action="{{URL::route('proses-ubah-pertanyaan')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$pertanyaan[0]->id}}">
                        <div class="card-body">
                            <h5 class="card-title">Form Edit Pertanyaan Minat & Bakat</h5>
                            <div class="form-group row">
                                <label for="kategori" class="col-sm-3 text-end control-label col-form-label">Kategori</label>
                                <div class="col-sm-9">
                                    <select name="kategori" id="kategori" class="form-control" required>
                                        <option value="minat" {{ $pertanyaan[0]->kategori == 'minat' ? 'selected' : '' }}>Minat</option>
                                        <option value="bakat" {{ $pertanyaan[0]->kategori == 'bakat' ? 'selected' : '' }}>Bakat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="objek_pilihan" class="col-sm-3 text-end control-label col-form-label">Objek Pilihan</label>
                                <div class="col-sm-9">
                                    <select name="objek_pilihan" id="objek_pilihan" class="form-control" required>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pernyataan" class="col-sm-3 text-end control-label col-form-label">Pernyataan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="pernyataan" id="pernyataan" value="{{$pertanyaan[0]->pernyataan}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{URL::route('pertanyaan')}}" class="btn btn-secondary">Batal</a>
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
    if (kategori && objekPilihan) {
        @if(isset($pertanyaan) && isset($pertanyaan[0]))
            setObjekPilihan(@json($pertanyaan[0]->objek_pilihan));
        @else
            setObjekPilihan();
        @endif
        kategori.addEventListener('change', function() {
            setObjekPilihan();
        });
    }
});
</script>
@endpush
