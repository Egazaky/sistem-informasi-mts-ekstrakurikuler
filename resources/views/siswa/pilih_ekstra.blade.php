@extends('siswa.template')
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pilih Ekstrakurikuler</h4>
                <form method="POST" action="{{ route('pilih-ekstra-proses') }}">
                    @csrf
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Ekstrakurikuler</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($ekstra as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nama_ekstra }}</td>
                                <td>
                                    <input class="form-check-input" type="checkbox" name="ekstra_id[]" value="{{ $item->id }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" style="margin-bottom: 20px;">Simpan Jawaban</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
