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
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th scope="row">Tahun</th>
                                        <th>Unit Pengusul</th>
                                        <th>Pengusul</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td scope="row">{{ $data->tahun->nama }}</td>
                                        <td>{{ $data->unit->nama }}</td>
                                        <td>{{ $data->user->name }}</td>
                                        <td>{{ $data->status }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if (!empty($data->catatan))
                        <div class="card">
                            <div class="card-header"><b>Catatan</b>
                            </div>
                            <div class="card-body">{{ $data->catatan }}
                            </div>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            {{-- <h3 class="card-title">{{ session('anak') }}</h3> --}}
                            @if ($data->status == 0 or $data->status == 2)
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">
                                    <i class="fa fa-plus-circle"></i> Tambah</a>
                                </button>
                                <a href="/indikator/detail/send/{{ Crypt::encrypt($data->id) }}"
                                    class="right btn btn-success btn-sm kirim-confirm" data-toggle="tooltip"
                                    data-placement="bottom" title="Ajukan Usulan">
                                    <i class="fas fa-paper-plane"></i> Ajukan
                                @else
                                    <button class="btn btn-primary btn-sm disabled" data-toggle="modal"
                                        data-target="#modal-default">
                                        <i class="fa fa-plus-circle"></i> Tambah</a>
                                </button>
                                <a href="/indikator/detail/send/{{ Crypt::encrypt($data->id) }}"
                                    class="right btn btn-success btn-sm disabled kirim-confirm" data-toggle="tooltip"
                                    data-placement="bottom" title="Ajukan Usulan">
                                    <i class="fas fa-paper-plane"></i> Ajukan
                            @endif
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Indikator</th>
                                        <th>Target</th>
                                        <th>Catatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data2 as $data2)
                                        <tr>
                                            <td>{{ $data2->nama }}</td>
                                            <td>{{ $data2->target }} {{ $data2->satuan->nama }}</td>
                                            <td>{{ $data2->catatan }}</td>
                                            <td>
                                                @if ($data->status == 0 or $data->status == 2)
                                                    <div class="col text-center">
                                                        <div class="btn-group">
                                                            <a href="/indikator/detail/edit/{{ Crypt::encrypt($data2->id) }}"
                                                                class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                data-placement="bottom" title="Edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="/indikator/detail/delete/{{ Crypt::encrypt($data2->id) }}"
                                                                class="btn btn-danger btn-sm delete-confirm"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Delete">
                                                                <i class="fas fa-ban"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col text-center">
                                                        <div class="btn-group">
                                                            <a href="/indikator/detail/edit/{{ Crypt::encrypt($data2->id) }}"
                                                                class="btn btn-warning btn-sm disabled"
                                                                data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="/indikator/detail/delete/{{ Crypt::encrypt($data2->id) }}"
                                                                class="btn btn-danger btn-sm delete-confirm disabled"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Delete">
                                                                <i class="fas fa-ban"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif

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
                <form method="POST" action="/indikator/detail/store">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Indikator</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- text input -->
                            <div class="col-12">
                                <input type="hidden" name="id" value="{{ $data->id }}" />
                                <div class="form-group">
                                    <label>Indikator</label>
                                    <textarea name="indikator" rows="5" class="form-control"
                                        required>{{ old('indikator') }}</textarea>
                                    @if ($errors->has('indikator'))
                                        <div class="text-danger">
                                            {{ $errors->first('indikator') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="form-control select2 " name="kategori" required>
                                        <option value="">Pilih</option>
                                        @foreach ($data3 as $list)
                                            <option value="{{ $list->id }}"
                                                {{ old('kategori') == $list->id ? 'selected' : '' }}>
                                                {{ $list->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tahun'))
                                        <div class="text-danger">
                                            {{ $errors->first('tahun') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Target</label>
                                    <div class="input-group mb-3">

                                        <input type="text" name="target" class="form-control" required
                                            value="{{ old('target') }}" />
                                        {{-- <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div> --}}
                                    </div>
                                    @if ($errors->has('target'))
                                        <div class="text-danger">
                                            {{ $errors->first('target') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <select class="form-control select2 " name="satuan" required>
                                        <option value="">Pilih</option>
                                        @foreach ($data4 as $list)
                                            <option value="{{ $list->id }}"
                                                {{ old('satuan') == $list->id ? 'selected' : '' }}>
                                                {{ $list->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('satuan'))
                                        <div class="text-danger">
                                            {{ $errors->first('satuan') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Catatan (Jika Perlu)</label>
                                    <textarea name="catatan" rows="2"
                                        class="form-control">{{ old('catatan') }}</textarea>
                                    @if ($errors->has('catatan'))
                                        <div class="text-danger">
                                            {{ $errors->first('catatan') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
                "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": false,
            });
        });
    </script>
    <script>
        $('.kirim-confirm').on('click', function(event) {
            event.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Data akan diajukan ke Admin",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ajukan!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        });
    </script>
@endsection
