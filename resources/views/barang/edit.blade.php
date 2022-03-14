@extends('layout')

@section('content')
    <h3 class="mb-3">Edit Barang</h3>

    <form method="POST" action="{{ url('') }}/admin/barang/{{ $barang->id }}">
        @method('PUT')
        @csrf

        <div class="form-group">
            <label for="idkategori">Kategori</label>
            <input type="text" class="form-control" id="idkategori" aria-describedby="emailHelp" name="idkategori" value="{{ $barang->idkategori }}">
            <small id="emailHelp" class="form-text text-muted">ID lategori barang yang hendak diuabh.</small>
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" aria-describedby="emailHelp" name="nama" value="{{ $barang->nama }}">
            <small id="emailHelp" class="form-text text-muted">Nama barang yang hendak diuabh.</small>
            <label for="harga">Harga</label>
            <input type="text" class="form-control" id="harga" aria-describedby="emailHelp" name="harga" value="{{ $barang->harga }}">
            <small id="emailHelp" class="form-text text-muted">Harga barang yang hendak diuabh.</small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
