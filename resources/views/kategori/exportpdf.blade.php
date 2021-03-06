@extends('layout-pdf')

@section('content')

<h3 id="title">Laporan Data Kategori</h3>

<body>
    <table class="table mt-4">
        <thead>
            <tr style="background-color: transparent;">
                <th>No.</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $kategori)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $kategori['kategori'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
@endsection
