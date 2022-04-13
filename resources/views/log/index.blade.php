@php

$entri = request('entri', 10);
$currentPage = request('page', 1);
$offset = ($currentPage - 1) * $entri;

@endphp

@extends('layout')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- {{dd($params)}} --}}
    <h3 class="mb-3">Log User</h3>

    {{-- <a href="/admin/kategori/create" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a> --}}
    <form action="{{ url('') }}/admin/log/exportpdf" class="d-inline" method="POST">
        @csrf
        <input type="hidden" name="q" value="{{request('q')}}">
        <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Export PDF</button>
    </form>
    {{-- <form action="{{ url('') }}/admin/kategori/exportexcel" class="d-inline" method="POST">
        @csrf
        <input type="hidden" name="q" value="{{request('q')}}">
        <button type="submit" class="btn btn-warning"><i class="fa fa-file-excel"></i> Export Excel</button>
    </form> --}}

    <div class="datatable-wrapper shadow-lg rounded mt-4">
        {{-- <div class="datatable-heading p-4 border-bottom">
            <b>Data Kategori</b>
        </div> --}}

        <div class="datatable-content p-4">
            <div class="datatable-search-wrap d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <p class="mb-0">Menampilkan</p>

                    <form action="/admin/log" class="mx-2">
                        <input type="hidden" name="page" value="{{ request('page') }}">
                        <input type="hidden" name="entri" value="{{ request('q') }}">
                        <select onchange="this.form.submit()" name="entri" id="" class="form-control py-0 px-2">
                            <option value="10" {{ $entri == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $entri == 25 ? 'selected' : '' }}>25</option>
                        </select>
                    </form>

                    <p class="mb-0">entri</p>
                </div>
                <div class="d-flex align-items-center">
                    <p class="mb-0 mr-2">Pencarian: </p>
                    <form action="/admin/log" method="get">
                        <input type="hidden" name="page" value="{{ request('page') }}">
                        <input type="hidden" name="entri" value="{{ request('entri') }}">
                        <input type="text" name="q" id="" class="form-control" value="{{ request('q') }}" />
                    </form>
                </div>
            </div>

            <table class="table mt-4">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">User</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $log)
                        <tr>
                            <th scope="row">{{ $offset + $i + 1 }}</th>
                            <td>{{ $log['iduser'] }}</td>
                            <td>{{ $log['menu'] }}</td>
                            <td>{{ $log['keterangan'] }}</td>
                            <td>{{ $log['created_at'] }}</td>
                            {{-- <td>
                                <div class="d-flex">
                                    <a href="/admin/kategori/{{ $kategori->id }}/edit" class="btn btn-warning mr-2"><i
                                            class="fa fa-edit"></i> Edit</a>

                                    <form action="/admin/kategori/{{ $kategori->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Apakah anda yakin ingin menghapus data?')"
                                            type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>
                                            Hapus</button>
                                    </form>
                                </div>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $data->links() }}
        </div>

    </div>

    {{-- {{ dd($data) }} --}}
@endsection
