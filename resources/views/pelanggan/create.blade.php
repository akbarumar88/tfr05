@extends('layout')

@section('content')
    <h3 class="mb-3">Tambah Pelanggan</h3>

    <form method="POST" action="{{ url('') }}/admin/pelanggan">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Nama Pelanggan</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="nama">
            <small id="emailHelp" class="form-text text-muted">Nama pelanggan yang hendak ditambahkan</small>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Alamat</label>
            <textarea name="alamat" id="" cols="30" rows="2" class="form-control"></textarea>
            {{-- <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="alamat"> --}}
            <small id="emailHelp" class="form-text text-muted">Alamat Pelanggan</small>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">No. Telp</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="notelp">
            <small id="emailHelp" class="form-text text-muted">No. Telepon pelanggan</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
