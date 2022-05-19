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
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-link">
                                    <i class="fas fa-link"></i></i> Link Indikator</a>
                                </button>
                                {{-- <a href="/indikator/cari" class="btn btn-info btn-sm" data-toggle="tooltip"
                                    data-placement="bottom" title="Tambah Link Indikator ">
                                    <i class="fas fa-link"></i></i> Link Indikator</a> --}}
                                <a href="/indikator/detail/send/{{ Crypt::encrypt($data->id) }}"
                                    class="btn btn-success btn-sm kirim-confirm" data-toggle="tooltip"
                                    data-placement="bottom" title="Ajukan Usulan">
                                    <i class="fas fa-paper-plane"></i> Ajukan</a>
                            @else
                                <button class="btn btn-primary btn-sm disabled" data-toggle="modal"
                                    data-target="#modal-default">
                                    <i class="fa fa-plus-circle"></i> Tambah</a>
                                </button>
                                <a href="/indikator/cari" class="btn btn-info btn-sm disabled" data-toggle="tooltip"
                                    data-placement="bottom" title="Tambah Link Indikator ">
                                    <i class="fas fa-link"></i></i> Link Indikator</a>
                                <a href="/indikator/detail/send/{{ Crypt::encrypt($data->id) }}"
                                    class="btn btn-success btn-sm disabled kirim-confirm" data-toggle="tooltip"
                                    data-placement="bottom" title="Ajukan Usulan">
                                    <i class="fas fa-paper-plane"></i> Ajukan</a>
                            @endif
                            <a href="/indikator" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-circle-left"></i>
                                Kembali</a>
                        </div>
                        <!-- /.card-header -->
                        @php
                            $total = 0;
                        @endphp
                        <div class="card-body">
                            <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>Kategori</th>
                                        <th>Indikator</th>
                                        <th>Definisi Operational</th>
                                        <th>Frekuensi Pengumpulan</th>
                                        <th>Periode Pelaporan</th>
                                        <th>Numerator</th>
                                        <th>Denumerator</th>
                                        <th>Sumber Data</th>
                                        <th>Target</th>
                                        <th>Bobot</th>
                                        <th style="min-width: 250px">Catatan</th>
                                        <th>PIC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data2 as $data2)
                                        <tr>
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
                                                            {{-- <a href="" class="btn btn-primary btn-sm" id="editCompany"
                                                                data-toggle="modal" data-target='#practice_modal'
                                                                data-id="{{ $data2->id }}" data-toggle="tooltip"
                                                                data-placement="bottom" title="Link Indikator">
                                                                <i class="fas fa-link"></i>
                                                            </a> --}}
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
                                                            {{-- <a href="#" class="btn btn-primary btn-sm disabled"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Link Indikator">
                                                                <i class="fas fa-link"></i>
                                                            </a> --}}
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
                                            <td>{{ $data2->kategori->nama }}</td>
                                            <td>{{ $data2->nama }}</td>
                                            <td>
                                                @php
                                                    $paragraphs = explode(PHP_EOL, $data2->do);
                                                @endphp
                                                @foreach ($paragraphs as $paragraph)
                                                    <p>{{ $paragraph }}</p>
                                                @endforeach
                                            </td>
                                            <td>{{ $data2->pengumpulan }}</td>
                                            <td>{{ $data2->pelaporan }}</td>
                                            <td>{{ $data2->numerator }}</td>
                                            <td>{{ $data2->denumerator }}</td>
                                            <td>{{ $data2->sumberdata }}</td>
                                            <td>{{ $data2->target }} {{ $data2->satuan->nama }}</td>
                                            <td>
                                                @if (!empty($data2->bobot))
                                                    {{ $data2->bobot }}%
                                                    @php
                                                        $total = $total + $data2->bobot;
                                                    @endphp
                                                @else
                                                    -
                                                @endif
                                            </td>
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
                                        </tr>
                                    @endforeach

                                </tbody>

                                <tfoot>
                                    <tr>
                                        @if ($total > 100)
                                            <td colspan="10" class="text-center font-weight-bold text-danger">Total bobot
                                                lebih dari 100%</td>
                                            <td colspan="3" class="font-weight-bold text-danger">{{ $total }}%</td>
                                        @elseif ($total < 100)
                                            <td colspan="10" class="text-center font-weight-bold text-danger">Total bobot
                                                kurang dari 100%</td>
                                            <td colspan="3" class="font-weight-bold text-danger">{{ $total }}%</td>
                                        @else
                                            <td colspan="10" class="text-center font-weight-bold">Total bobot
                                                100%</td>
                                            <td colspan="3" class="font-weight-bold">{{ $total }}%</td>
                                        @endif
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Link Indikator</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>Kategori</th>
                                        <th>Link Indikator</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data5 as $data5)
                                        <tr>
                                            <td>
                                                @if ($data->status == 0 or $data->status == 2)
                                                    <div class="col text-center">
                                                        <div class="btn-group">
                                                            <a href="/detail/link/{{ Crypt::encrypt($data5->id) }}/delete"
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
                                                            <a href="/detail/link/{{ Crypt::encrypt($data5->id) }}/delete"
                                                                class="btn btn-danger btn-sm delete-confirm disabled"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Delete">
                                                                <i class="fas fa-ban"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif

                                            </td>
                                            <td>{{ $data5->kategori->nama }}</td>
                                            <td>{{ $data5->detailindikator->nama }}
                                                link <i>{{ $data5->detailindikator->indikator->unit->nama }}</i>
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
                                    <textarea name="indikator" rows="1" class="form-control" required>{{ old('indikator') }}</textarea>
                                    @if ($errors->has('indikator'))
                                        <div class="text-danger">
                                            {{ $errors->first('indikator') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Definisi Operasional</label>
                                    <textarea name="do" rows="3" class="form-control" required>{{ old('do') }}</textarea>
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
                            <div class="col-4">
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
                            <div class="col-4">
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
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Bobot Penilaian</label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="bobot" class="form-control" required
                                            value="{{ old('bobot') }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div>
                                    </div>
                                    @if ($errors->has('bobot'))
                                        <div class="text-danger">
                                            {{ $errors->first('bobot') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Catatan</label><small>* Optional</small>
                                    <textarea name="catatan" rows="2" class="form-control">{{ old('catatan') }}</textarea>
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-link">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="/detail/link/store">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Link Indikator</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- text input -->
                            <div class="col-12">
                                <input type="hidden" name="indikator_id" value="{{ $data->id }}" />
                                <div class="form-group">
                                    <label>Cari Indikator</label>
                                    <select class="cariIndikator form-control" style="width: 100%" id="cariIndikator"
                                        name="cari" required>
                                        <option value="">Cari</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Definisi Operasional</label>
                                    <textarea rows="3" class="form-control" id="link-do" readonly>{{ old('do') }}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <input type="text" class="form-control" id="link-kategori" value="" readonly />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Unit Pengusul</label>
                                    <input type="text" class="form-control" id="link-unit" value="" readonly />
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Frekuensi Pengumpulan Data</label>
                                    <input type="text" class="form-control" id="link-pengumpulan" value="" readonly />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Periode Pelaporan</label>
                                    <input type="text" class="form-control" id="link-pelaporan" value="" readonly />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Target</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" readonly value="" id="link-target" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" id="link-satuan" readonly value="" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Bobot Penilaian</label>
                                    <div class="input-group mb-3">
                                        <input type="number" name="bobot" class="form-control" required step="0.05"
                                            max="100" value="{{ old('bobot') }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div>
                                    </div>
                                    @if ($errors->has('bobot'))
                                        <div class="text-danger">
                                            {{ $errors->first('bobot') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Link Kategori</label>
                                    <select class="form-control select2 " name="kategori" id="kategori" required>
                                        <option value="">Pilih</option>
                                        @foreach ($data3 as $datakategori)
                                            <option value="{{ $datakategori->id }}"
                                                {{ old('kategori') == $datakategori->id ? 'selected' : '' }}>
                                                {{ $datakategori->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Link Sub Kategori</label>
                                    <div class="input-group">
                                        <select class="form-control select2" name="subkategori" id="subkategori" disabled>
                                            <option value="">Pilih</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="practice_modal">
        <div class="modal-dialog modal-lg">
            <form action="/detail/link/store" method="POST">
                @csrf
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title">Link Indikator</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" id="detail_indikator_id" name="detail_indikator_id" value=""
                                    class="form-control" readonly>
                                <input type="text" id="indikator_id" name="indikator_id" value="" class="form-control"
                                    readonly>
                                <div class="form-group">
                                    <label>Nama Indikator</label>
                                    <input type="text" name="name" id="name" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="form-control select2 " name="kategori" id="kategori" required>
                                        <option value="">Pilih</option>
                                        @foreach ($data3 as $list)
                                            <option value="{{ $list->id }}"
                                                {{ old('kategori') == $list->id ? 'selected' : '' }}>
                                                {{ $list->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        {{-- <input type="submit" value="Submit" id="submit" class="btn btn-sm btn-outline-danger py-0"
                        style="font-size: 0.8em;"> --}}

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('ajax')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <!-- Select2 -->
    <script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.cariIndikator')
            .select2({
                placeholder: 'Cari...',
                ajax: {
                    url: '/getIndikator',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        // console.log(data);
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama,
                                    do: item.do,
                                    kategori: item.kategori,
                                    pengumpulan: item.pengumpulan,
                                    pelaporan: item.pelaporan,
                                    target: item.target,
                                    satuan: item.satuan,
                                    unit: item.unit,
                                    indikator_id: item.indikator_id,
                                    id: item.id
                                }
                            })

                        };
                    },
                    cache: true
                }
            });

        $('.cariIndikator').on('select2:select', function(e) {
            var data = e.params.data;
            console.log(data);
            // alert(data['text']);
            $('#link-do').val(data.do);
            $('#link-kategori').val(data.kategori);
            $('#link-pelaporan').val(data.pelaporan);
            $('#link-pengumpulan').val(data.pengumpulan);
            $('#link-satuan').val(data.satuan);
            $('#link-target').val(data.target);
            $('#link-unit').val(data.unit);
            $('#link-indikator').val(data.indikator_id);
        });

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '#submit', function(event) {
                event.preventDefault()
                var detail_indikator_id = $("#detail_indikator_id").val();
                var indikator_id = $("#indikator_id").val();
                var kategori = $("#kategori").val();

                $.ajax({
                    url: '/detail/link/store',
                    type: "POST",
                    data: {
                        detail_indikator_id: detail_indikator_id,
                        indikator_id: indikator_id,
                        kategori_id: kategori,
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#companydata').trigger("reset");
                        $('#practice_modal').modal('hide');
                        window.location.reload(true);
                    }
                });
            });

            $('body').on('click', '#editCompany', function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                console.log(id)
                $.get('/detail/' + id + '/indikator', function(data) {
                    $('#userCrudModal').html("Link Indikator");
                    $('#submit').val("Simpan");
                    $('#practice_modal').modal('show');
                    $('#detail_indikator_id').val(data.data.id);
                    $('#indikator_id').val(data.data.indikator_id);
                    $('#name').val(data.data.nama);
                })
            });
        });
    </script>
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
        });
        $(function() {
            $('#kategori').on('change', function() {
                axios.post('{{ route('getSubKategori') }}', {
                        id: $(this).val()
                    })
                    .then(function(response) {
                        if (!response.data || response.data.length == 0) {
                            $('#subkategori').empty();
                            $('#subkategori').append(new Option("Tidak Ada Sub"));
                            $('#subkategori').attr('disabled', 'disabled');
                        } else {
                            $('#subkategori').removeAttr('disabled');
                            $('#subkategori').empty();
                            // log.console(response);
                            $('#subkategori').append(new Option("Pilih"))

                            $.each(response.data, function(id, nama) {
                                $('#subkategori').append(new Option(nama, id))
                            })
                        }
                    });
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
