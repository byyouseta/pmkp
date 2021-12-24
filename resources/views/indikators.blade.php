@extends('layouts.master')

@section('head')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            {{-- <h3 class="card-title">{{ session('anak') }}</h3> --}}
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">
                                <i class="fa fa-plus-circle"></i> Tambah</a>
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Tahun</th>
                                        <th>Unit Pengusul</th>
                                        <th>Pengusul</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $data)
                                        <tr>
                                            <td>{{ $data->tahun->nama }}</td>
                                            <td>{{ $data->unit->nama }}</td>
                                            <td>{{ $data->user->name }}</td>
                                            <td>
                                                @php
                                                    echo \App\Indikator::status($data->status);
                                                @endphp
                                            </td>
                                            <td>
                                                <div class="col text-center">
                                                    <div class="btn-group">
                                                        <a href="/indikator/{{ Crypt::encrypt($data->id) }}"
                                                            class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                            data-placement="bottom" title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        {{-- <a href="/user/delete/{{ Crypt::encrypt($data->id) }}"
                                                            class="btn btn-danger btn-sm delete-confirm"
                                                            data-toggle="tooltip" data-placement="bottom" title="Delete">
                                                            <i class="fas fa-ban"></i>
                                                        </a> --}}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="/indikator/store">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Pengajuan Imut</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- text input -->
                            <div class="col-12">

                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select class="form-control select2 " name="tahun" required>
                                        <option value="">Pilih</option>
                                        @foreach ($data2 as $tahun)
                                            <option value="{{ $tahun->id }}"
                                                {{ old('tahun') == $tahun->id ? 'selected' : '' }}>
                                                {{ $tahun->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tahun'))
                                        <div class="text-danger">
                                            {{ $errors->first('tahun') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Unit</label>
                                    {{-- <input type="text" name="unit" class="form-control" readonly
                                        value="{{ Auth::user()->unit->nama }}" /> --}}
                                    <select class="form-control select2 " name="unit_id" required>
                                        <option value="">Pilih</option>
                                        @foreach ($data3 as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('unit_id'))
                                        <div class="text-danger">
                                            {{ $errors->first('unit_id') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" rows="3" placeholder="Masukkan Keterangan(Jika ada)"
                                        name="keterangan">{{ old('keterangan') }}</textarea>
                                    @if ($errors->has('keterangan'))
                                        <div class="text-danger">
                                            {{ $errors->first('keterangan') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                        <button type="Submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
@section('plugin')
    {{-- <!-- jQuery -->
    <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('template/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('template/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
            });
        });
    </script>
@endsection
