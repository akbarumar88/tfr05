@php
// dd(auth()->user());
@endphp

@extends('layout')

@section('content')
    <h3 class="mb-3">Penjualan Barang</h3>

    <form method="POST" action="{{ url('') }}/admin/kategori">
        @csrf

        <input type="hidden" name="iduser" value="{{ auth()->user()->id }}">
        <div class="form-row justify-content-between">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Kasir</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="kasir"
                    readonly value="{{ auth()->user()->nama }}">
                <small id="emailHelp" class="form-text text-muted">Kasir yang bertanggungjawab</small>
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Pelanggan</label>
                <select name="idpelanggan" id="pelanggan" aria-describedby="pelangganHelp" class="form-control">
                    @foreach ($pelanggan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach

                </select>
                <small id="pelangganHelp" class="form-text text-muted">Pilih Pelanggan (opsional)</small>
            </div>
        </div>

        <div class="form-row justify-content-between">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">No. Faktur</label>
                <input placeholder="No. Faktur akan terisi secara otomatis" type="text" class="form-control"
                    id="exampleInputEmail1" aria-describedby="emailHelp" name="nofaktur" readonly>
                <small id="emailHelp" class="form-text text-muted">No. Faktur Transaksi</small>
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Tanggal</label>
                <input type="date" max="{{ date('Y-m-d') }}" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" name="tgl" value="{{ date('Y-m-d') }}">
                <small id="emailHelp" class="form-text text-muted">Tanggal Transaksi</small>
            </div>
        </div>

        <a href="{{url('') . '/admin/penjualan/pilihbarang'}}" class="btn btn-success"><i class="fa fa-plus"></i> Obat</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
    </form>
@endsection
