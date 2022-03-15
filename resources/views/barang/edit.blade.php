@extends('layout')

@section('content')
    <h3 class="mb-3">Edit Barang</h3>

    <form method="POST" action="{{ url('') }}/admin/barang/{{ $barang->id }}">
        @method('PUT')
        @csrf

        <div class="form-group">
            <label for="idkategori">Kategori</label>
            <select class="form-control" name="kategori" id="kategori">
                @foreach ($kategori as $i => $kategori)
                    @if ($kategori->id == $barang->idkategori)
                        <option value="{{ $kategori['id'] }}" selected>{{ $kategori['kategori'] }}</option>
                    @else
                        <option value="{{ $kategori['id'] }}">{{ $kategori['kategori'] }}</option>
                    @endif
                @endforeach
            </select>
            <small id="emailHelp" class="form-text text-muted">Kategori barang yang hendak diubah.</small>
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" aria-describedby="emailHelp" name="nama" value="{{ $barang->nama }}">
            <small id="emailHelp" class="form-text text-muted">Nama barang yang hendak diubah.</small>
            <label for="harga">Harga</label>
            <input type="text" class="form-control" id="harga" aria-describedby="emailHelp" name="harga" value="{{ $barang->harga }}">
            <small id="emailHelp" class="form-text text-muted">Harga barang yang hendak diubah.</small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
