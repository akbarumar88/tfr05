@php
// dd(auth()->user());
$iduser = auth()->user()->id;
$session_penjualan = session($iduser . '_penjualan', []);
$cart = collect(session($iduser . '_cart', []));
// dd($session_penjualan);
$grandTotal = 0;
$cart->each(function ($barang, $i) use (&$grandTotal) {
    // dd($barang);
    $grandTotal += $barang['jumlah'] * $barang['harga'];
});

// dd(old('tgl', $session_penjualan['tgl']))

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
                        @php
                            $selected = old('idpelanggan', $session_penjualan['idpelanggan']);
                            $isSelected = $item->id == $selected ? 'selected' : '';
                        @endphp
                        <option value="{{ $item->id }}" {{ $isSelected }}>{{ $item->nama }}</option>
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
                    name="tgl" value="{{ old('tgl', $session_penjualan['tgl']) }}">
                <small id="emailHelp" class="form-text text-muted">Tanggal Transaksi</small>
            </div>
        </div>

        <div class="form-row justify-content-between">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Jumlah Bayar</label>
                <input placeholder="Jumlah Bayar" type="number" class="form-control" id="bayar"
                    aria-describedby="emailHelp" name="bayar" step="500"
                    value="{{ old('bayar', $session_penjualan['bayar'] ?? '') }}">
                <small id="emailHelp" class="form-text text-muted">Jumlah Bayar</small>
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Jumlah Kembalian</label>
                <input placeholder="Jumlah Kembali" type="text" class="form-control" id="kembali"
                    aria-describedby="emailHelp" name="kembali" readonly
                    value="{{ old('kembali', $session_penjualan['kembali'] ?? '') }}">
                <small id="emailHelp" class="form-text text-muted">Jumlah Kembali</small>
            </div>
        </div>

        <a href="#" class="btn btn-success" id="pilihbarang"><i class="fa fa-plus"></i>
            Barang</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>

        @if ($cart->isNotEmpty())
            <h1 id="grandtotal" class="text-right">{{ number_format($grandTotal) }}</h1>
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
                        <tr data-value="{{json_encode($barang)}}">
                            <td>
                                <input type="hidden" name="id" value="{{ $barang['id'] }}">
                                <button type="button" class="btn btn-sm btn-danger hapus"><i style="" class="fa fa-trash"></i></button>
                            </td>
                            <td>{{ $barang['nama'] }}</td>
                            <td>{{ number_format($barang['harga']) }}</td>
                            <td>
                                <input type="number" value="{{ $barang['jumlah'] }}" class="form-control cart-jumlah"
                                    style="width:auto" data-value="{{ json_encode($barang) }}">
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
            let bayar = $("#bayar").val()
            let kembali = $("#kembali").val()

            let value = {
                idpelanggan,
                tgl,
                kembali,
                bayar
            }
            // console.log(value); return
            NProgress.start()
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
                    NProgress.done()
                    console.log('success Set SESSION', res)
                    let urlTo = "{{ url('') . '/admin/penjualan/pilihbarang' }}"
                    window.location.href = urlTo
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    NProgress.done()
                    console.log('ERROR Set SESSION', {
                        resText: jqXHR.responseText,
                        textStatus,
                        errorThrown
                    })
                }
            });
        })

        function calculateGrandTotal() {
            let grandTotal = 0
            $(".cart-jumlah").each(function(el) {
                let jml = $(this).val()
                let barang = $(this).data('value')
                let subtotal = barang.harga * jml
                // console.log({jml,barang,subtotal})
                grandTotal += subtotal
                // console.log(el)
            })
            let grandTotalFormat = new Intl.NumberFormat().format(grandTotal)
            // console.log(grandTotal)
            $('#grandtotal').html(grandTotalFormat)
            return grandTotal
        }

        $(".cart-jumlah").change(function(e) {
            let barang = $(this).data('value')
            let jml = e.target.value
            let subtotal = barang.harga * jml
            subtotal = new Intl.NumberFormat().format(subtotal)

            $(this).parent().siblings(".cart-subtotal").html(subtotal)
            calculateGrandTotal()
            // console.log(jml, barang)
        })

        $("#bayar").change(function(e) {
            let bayar = $(this).val()
            let grandTotal = calculateGrandTotal()
            let kembali = bayar - grandTotal
            console.log('masuk bayar change', {
                bayar,
                grandTotal,
                kembali
            })
            let kembaliFormat = new Intl.NumberFormat().format(kembali)
            $("#kembali").val(kembaliFormat)
        })

        $(".hapus").click(function (e) {
            let yes = confirm('Apakah anda yakin ingin menghapus data?')
            if (!yes) return // Jika pilih tidak, maka return

            let trElement = $(this).parent().parent()
            let barang = trElement.data('value')

            // console.log(barang); return
            let url = "{{ url('') . '/admin/penjualan/hapusbarang' }}"
            NProgress.start()
            $.ajax({
                type: "POST",
                url,
                data: ({
                    '_token': "{{ csrf_token() }}",
                    id: barang.id
                }),
                dataType: "JSON",
                contentType: 'application/x-www-form-urlencoded; charset=utf-8',
                success: function(res) {
                    NProgress.done()
                    console.log('success Hapus Barang', res)
                    // Hapus dari DOM
                    trElement.remove()
                    calculateGrandTotal()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    NProgress.done()
                    console.log('ERROR Hapus Barang', {
                        resText: jqXHR.responseText,
                        textStatus,
                        errorThrown
                    })
                }
            });
        })
    </script>
@endsection
