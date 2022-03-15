@extends('layout-pdf')

@section('content')
<h3 id="title">Laporan Data Barang</h3>

<body>
    <table class="table mt-4">
        <thead>
            <tr style="background-color: transparent;">
                <th>No.</th>
                <th>Kategori Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $barang)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $barang['kategori'] }}</td>
                    <td>{{ $barang['nama'] }}</td>
                    <td>{{ $barang['harga'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
@endsection
