@extends('layout-pdf')

@section('content')
<h3 id="title">Laporan Log User</h3>

<body>
    <table class="table mt-4">
        <thead>
            <tr style="background-color: transparent;">
                <th>No.</th>
                <th>User</th>
                <th>Menu</th>
                <th>Keterangan</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $log)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $log['user'] }}</td>
                    <td>{{ $log['menu'] }}</td>
                    <td>{{ $log['keterangan'] }}</td>
                    <td>{{ $log['created_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
@endsection
