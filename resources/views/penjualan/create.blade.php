@php
// dd(auth()->user());
$iduser = auth()->user()->id;
$session_penjualan = session($iduser.'_penjualan', []);
$cart = collect(session($iduser . '_cart', []));

@endphp

@extends('layout')

@section('content')
    <style>
        #cart td,
        #cart th {
            font-size: 14px;
        }

    </style>

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
                <input type="date" max="{{ date('Y-m-d') }}" class="form-control" id="tgl" aria-describedby="emailHelp"
                    name="tgl" value="{{ date('Y-m-d') }}">
                <small id="emailHelp" class="form-text text-muted">Tanggal Transaksi</small>
            </div>
        </div>

        <a href="#" class="btn btn-success" id="pilihbarang"><i class="fa fa-plus"></i>
            Obat</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>

        @if ($cart->isNotEmpty())
            <table class="table table-striped mt-4" id="cart">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $barang)
                        @php
                            $subtotal = $barang['jumlah'] * $barang['harga'];
                        @endphp
                        <tr>
                            <td>
                                <form action="<?= url('') ?>/admin/penjualan/uncentang" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <input type="hidden" name="id" value="{{ $barang['id'] }}">
                                    <button onclick="return confirm('Apakah anda yakin ingin menghapus data?')" type="submit"
                                        class="btn btn-sm btn-danger"><i style="" class="fa fa-trash"></i></button>
                                </form>
                            </td>
                            <td>{{ $barang['nama'] }}</td>
                            <td>{{ number_format($barang['harga']) }}</td>
                            <td>
                                <input type="number" value="{{ $barang['jumlah'] }}" class="form-control cart-jumlah"
                                    style="width:auto" data-value="{{json_encode($barang)}}">
                                {{-- <p>{{ $barang['jumlah'] }}</p> --}}
                            </td>
                            <td class="cart-subtotal">{{ number_format($subtotal) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </form>

    <script>
        $('#pilihbarang').click(function(e) {
            // Simpan Current Data ke Session
            let url = "{{ url('') . '/admin/penjualan/setsession' }}"
            let idpelanggan = $('#pelanggan').val()
            let tgl = $('#tgl').val()

            let value = {
                idpelanggan,
                tgl
            }
            // console.log(value); return
            $.ajax({
                type: "POST",
                url,
                data: ({
                    '_token': "{{ csrf_token() }}",
                    ...value
                }),
                dataType: "JSON",
                contentType: 'application/x-www-form-urlencoded; charset=utf-8',
                success: function(res) {
                    console.log('success Set SESSION', res)
                    let urlTo = "{{ url('') . '/admin/penjualan/pilihbarang' }}"
                    window.location.href = urlTo
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('ERROR Set SESSION', {
                        resText: jqXHR.responseText,
                        textStatus,
                        errorThrown
                    })
                }
            });
        })

        $(".cart-jumlah").change(function (e) {
            let barang = $(this).data('value')
            let jml = e.target.value
            let subtotal = barang.harga * jml
            subtotal = new Intl.NumberFormat().format(subtotal)

            $(this).parent().siblings(".cart-subtotal").html(subtotal)
            // console.log(jml, barang)
        })
    </script>
@endsection
