@extends('layout')

@section('content')
    <h3 class="mb-3">Tambah Kategori</h3>

    <form method="POST" action="/admin/kategori">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Nama Kategori</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="kategori">
            <small id="emailHelp" class="form-text text-muted">Nama kategori yang hendak ditambahkan.</small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
