@extends('layouts.master')

@section('head')
    <!-- DataTables -->
    {{-- <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}"> --}}

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"></script>
    <script src="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css"></script> --}}
    {{-- <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.bootstrap4.min.css"></script> --}}
    {{-- <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.bootstrap4.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
    <style type="text/css" class="init">
    </style>

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
    <script type="text/javascript" class="init">
        $(document).ready(function() {
            var table = $('#example').DataTable({
                scrollY: "400px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                info: false,
                columnDefs: [{
                    width: "200px",
                    targets: 1
                }],
                fixedColumns: {
                    left: 2,
                },
                dom: 'Bfrtip',
                buttons: [
                    'excel',
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    }
                ]
            });
        });
    </script>

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
                                        <td>
                                            @php
                                                echo \App\Indikator::status($data->status);
                                            @endphp
                                        </td>
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
                                    class="btn btn-success btn-sm kirim-confirm" data-toggle="tooltip"
                                    data-placement="bottom" title="Ajukan Usulan">
                                    <i class="fas fa-paper-plane"></i> Ajukan</a>
                            @else
                                <button class="btn btn-primary btn-sm disabled" data-toggle="modal"
                                    data-target="#modal-default">
                                    <i class="fa fa-plus-circle"></i> Tambah</a>
                                </button>
                                <a href="/indikator/detail/send/{{ Crypt::encrypt($data->id) }}"
                                    class="btn btn-success btn-sm disabled kirim-confirm" data-toggle="tooltip"
                                    data-placement="bottom" title="Ajukan Usulan">
                                    <i class="fas fa-paper-plane"></i> Ajukan</a>
                            @endif
                            <a href="/indikator" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-circle-left"></i>
                                Kembali</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Indikator</th>
                                        <th>Definisi Operational</th>
                                        <th>Frekuensi Pengumpulan</th>
                                        <th>Periode Pelaporan</th>
                                        <th>Numerator</th>
                                        <th>Denumerator</th>
                                        <th>Sumber Data</th>
                                        <th>Target</th>
                                        <th style="min-width: 250px">Catatan</th>
                                        <th>PIC</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data2 as $data2)
                                        <tr>
                                            <td>{{ $data2->kategori->nama }}</td>
                                            <td>{{ $data2->nama }}</td>
                                            <td>{{ $data2->do }}</td>
                                            <td>{{ $data2->pengumpulan }}</td>
                                            <td>{{ $data2->pelaporan }}</td>
                                            <td>{{ $data2->numerator }}</td>
                                            <td>{{ $data2->denumerator }}</td>
                                            <td>{{ $data2->sumberdata }}</td>
                                            <td>{{ $data2->target }} {{ $data2->satuan->nama }}</td>
                                            <td>
                                                @php
                                                    $paragraphs = explode(PHP_EOL, $data2->catatan);
                                                @endphp
                                                @foreach ($paragraphs as $paragraph)
                                                    <p>{{ $paragraph }}</p>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if (!empty($data2->user_id))
                                                    {{ $data2->user->name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->status == 0 or $data->status == 2)
                                                    <div class="col text-center">
                                                        <div class="btn-group">
                                                            <a href="/detail/edit/{{ Crypt::encrypt($data2->id) }}"
                                                                class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                data-placement="bottom" title="Edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="/detail/range/{{ Crypt::encrypt($data2->id) }}"
                                                                class="btn btn-info btn-sm" data-toggle="tooltip"
                                                                data-placement="bottom" title="Input Range Nilai">
                                                                <i class="fas fa-list"></i>
                                                            </a>
                                                            <a href="/detail/delete/{{ Crypt::encrypt($data2->id) }}"
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
                                                            <a href="/detail/edit/{{ Crypt::encrypt($data2->id) }}"
                                                                class="btn btn-warning btn-sm disabled"
                                                                data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="/detail/range/{{ Crypt::encrypt($data2->id) }}"
                                                                class="btn btn-info btn-sm disabled" data-toggle="tooltip"
                                                                data-placement="bottom" title="Input Range Nilai">
                                                                <i class="fas fa-list"></i>
                                                            </a>
                                                            <a href="/detail/delete/{{ Crypt::encrypt($data2->id) }}"
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
        <div class="modal-dialog modal-lg">
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
                                    <textarea name="indikator" rows="1" class="form-control"
                                        required>{{ old('indikator') }}</textarea>
                                    @if ($errors->has('indikator'))
                                        <div class="text-danger">
                                            {{ $errors->first('indikator') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Definisi Operasional</label>
                                    <textarea name="do" rows="3" class="form-control"
                                        required>{{ old('do') }}</textarea>
                                    @if ($errors->has('do'))
                                        <div class="text-danger">
                                            {{ $errors->first('do') }}
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
                                    <label>Frekuensi Pengumpulan Data</label>
                                    <select class="form-control select2 " name="pengumpulan" required>
                                        <option value="">Pilih</option>
                                        <option value="Harian">Harian</option>
                                        <option value="Mingguan">Mingguan</option>
                                        <option value="Bulanan">Bulanan</option>
                                    </select>
                                    @if ($errors->has('pengumpulan'))
                                        <div class="text-danger">
                                            {{ $errors->first('pengumpulan') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Periode Pelaporan</label>
                                    <select class="form-control select2 " name="pelaporan" required>
                                        <option value="">Pilih</option>
                                        <option value="Harian">Harian</option>
                                        <option value="Mingguan">Mingguan</option>
                                        <option value="Bulanan">Bulanan</option>
                                    </select>
                                    @if ($errors->has('pelaporan'))
                                        <div class="text-danger">
                                            {{ $errors->first('pelaporan') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Numerator</label><small>* Optional</small>
                                    <div class="input-group mb-3">
                                        <input type="text" name="numerator" class="form-control"
                                            value="{{ old('numerator') }}" />
                                        {{-- <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div> --}}
                                    </div>
                                    @if ($errors->has('numerator'))
                                        <div class="text-danger">
                                            {{ $errors->first('numerator') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Denumerator</label><small>* Optional</small>
                                    <div class="input-group mb-3">

                                        <input type="text" name="denumerator" class="form-control"
                                            value="{{ old('denumerator') }}" />
                                        {{-- <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div> --}}
                                    </div>
                                    @if ($errors->has('denumerator'))
                                        <div class="text-danger">
                                            {{ $errors->first('denumerator') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Sumber Data</label><small>* Optional</small>
                                    <div class="input-group mb-3">

                                        <input type="text" name="sumberdata" class="form-control"
                                            value="{{ old('sumberdata') }}" />
                                        {{-- <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div> --}}
                                    </div>
                                    @if ($errors->has('sumberdata'))
                                        <div class="text-danger">
                                            {{ $errors->first('sumberdata') }}
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
                                    <label>Catatan</label><small>* Optional</small>
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
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
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
    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>

    <script>
        $(function() {
            $('#example2').DataTable()
            $('#example3').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': false,
                "scrollY": "500px",
                "scrollX": true,
                "scrollCollapse": false,
                "autoWidth": false,
                "fixedHeader": {
                    "header": false,
                    "footer": false
                },
                "fixedColumns": {
                    "left": 2,
                },
            })
        })
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
