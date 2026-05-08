@extends('siswa.template')
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                @if(isset($questions))
                <h4 class="card-title">Kuesioner Minat & Bakat Siswa</h4>
                <form method="POST" action="{{ route('minat-bakat.store') }}">
                    @csrf
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pernyataan</th>
                                <th>Jawaban</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                        @foreach($questions as $q)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>
                                    <b>[{{ ucfirst($q->kategori) }} - {{ $q->objek_pilihan }}]</b><br>
                                    {{ $q->pernyataan }}
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <label style="margin-right:16px;">
                                            <input type="radio" name="jawaban[{{ $q->id }}]" value="1" required
                                                @if(isset($jawaban_terakhir[$q->id]) && $jawaban_terakhir[$q->id] == 1) checked @endif
                                            > Ya
                                        </label>
                                        <label>
                                            <input type="radio" name="jawaban[{{ $q->id }}]" value="0" required
                                                @if(isset($jawaban_terakhir[$q->id]) && $jawaban_terakhir[$q->id] == 0) checked @endif
                                            > Tidak
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-success">Simpan Jawaban & Lihat Rekomendasi</button>
                </form>
                @elseif(isset($soal))
                <h4 class="card-title">Soal Ekstrakurikuler</h4>
                <form method="POST" action="{{ route('simpan-soal') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pertanyaan</th>
                                    <th>Setuju (S)</th>
                                    <th>Kurang Setuju (KS)</th>
                                    <th>Tidak setuju (TS)</th>
                                    <th>Sangat Tidak Setuju (STS)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($soal as $s)
                                @if ($s->kriteria_id == 4)
                                <tr>
                                    <td><h5>{{$s->pertanyaan}}</h5></td>
                                    <td>
                                    <input type="radio" class="form-check-input"
                                    name="radioid[{{$s->id}}]" value="80"  required>
                                    </td>
                                    <td>
                                    <input type="radio" class="form-check-input"
                                    name="radioid[{{$s->id}}]" value="60" required>
                                    </td>
                                    <td>
                                    <input type="radio" class="form-check-input"
                                    name="radioid[{{$s->id}}]" value="40" required>
                                    </td>
                                    <td>
                                    <input type="radio" class="form-check-input"
                                    name="radioid[{{$s->id}}]" value="20" required>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td><h5>{{$s->pertanyaan}}</h5></td>
                                    <td>
                                    <input type="radio" class="form-check-input"
                                    name="radioid[{{$s->id}}]" value="40" required>
                                    </td>
                                    <td>
                                    <input type="radio" class="form-check-input"
                                    name="radioid[{{$s->id}}]" value="30" required>
                                    </td>
                                    <td>
                                    <input type="radio" class="form-check-input"
                                    name="radioid[{{$s->id}}]" value="20" required>
                                    </td>
                                    <td>
                                    <input type="radio" class="form-check-input"
                                    name="radioid[{{$s->id}}]"  value="10" required>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-bottom: 20px;">Simpan Jawaban</button>
                </form>
                @else
                <div class="alert alert-warning">Tidak ada data soal yang tersedia.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
