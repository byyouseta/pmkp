@extends('layouts.master')

@section('head')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Tempusdominus|Datetime Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form action="/subkategori/store" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header"><b>Input Sub Kategori</b>
                                <div class="float-right">
                                    <a class="btn btn-secondary btn-sm" href="/kategori">
                                        Kembali</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <div class="form-group">
                                    <input type="text" name="subkategori" class="form-control"
                                        placeholder="Nama Sub Kategori" value="{{ old('subkategori') }}" required />
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="Submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                        <!-- /.card -->
                    </form>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title"><b>Daftar Sub Kategori</b></div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kategori</th>
                                        <th>Nama Sub Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data2 as $index=>$list)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $list->kategori->nama }}</td>
                                            <td>{{ $list->nama }}</td>
                                            <td>
                                                <a href="/subkategori/delete/{{ Crypt::encrypt($list->id) }}"
                                                    class="btn btn-danger btn-sm delete-confirm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Delete">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Masih belum ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
