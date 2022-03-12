@extends('layout')

@section('content')

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif

    <h3 class="mb-3">Data Kategori</h3>

    <button class="btn btn-success"><i class="fa fa-plus"></i> Tambah</button>

    <div class="datatable-wrapper shadow-lg rounded mt-4">
        <div class="datatable-heading p-4 border-bottom">
            <b>Data Kategori</b>
        </div>

        <div class="datatable-content p-4">
            <div class="datatable-search-wrap d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <p class="mb-0">Menampilkan</p>
                    <select name="" id="" class="form-control py-0 px-2 mx-2">
                        <option value="">10</option>
                        <option value="">25</option>
                    </select>
                    <p class="mb-0">entri</p>
                </div>
                <div class="d-flex align-items-center">
                   <p class="mb-0 mr-2">Pencarian: </p>
                    <input type="text" name="" id="" class="form-control" />
                </div>
            </div>

            <table class="table mt-4">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $kategori)
                        <tr>
                            <th scope="row">{{ $i + 1 }}</th>
                            <td>{{ $kategori['kategori'] }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="/admin/kategori/{{$kategori->id}}/edit" class="btn btn-warning mr-2"><i class="fa fa-edit"></i> Edit</a>
                                    <form action="">
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    {{-- {{ dd($data) }} --}}
@endsection
