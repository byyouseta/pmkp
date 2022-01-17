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
                    {{-- <form action="/indikator/list/store" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label">Tanggal</label>

                                    <div class="col-sm-3 input-group date" id="tanggal" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#tanggal"
                                            name="tanggal" value="{{ old('tanggal') }}" data-toggle="datetimepicker"
                                            autocomplete="off" placeholder="Pilih Tanggal" required />
                                        <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Target</th>
                                            <th>Catatan</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data2 as $index => $item)
                                            <tr>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->kategori->nama }}</td>
                                                <td>{{ $item->target }}{{ $item->satuan->nama }}</td>
                                                <td>{{ $item->catatan }}</td>
                                                <td>
                                                    <input type="hidden" name="id[{{ $index }}]"
                                                        value="{{ $item->id }}">
                                                    @if (empty($item->denumerator) and empty($item->numerator))
                                                        <div class="input-group">
                                                            <input type="text" name="nilai[{{ $index }}]"
                                                                class="form-control"
                                                                placeholder="Ketikkan Nilai sesuai Tanggal" required />
                                                            <div class="input-group-append">
                                                                <span
                                                                    class="input-group-text">{{ $item->satuan->nama }}</span>
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
                            <div class="card-footer">
                                <button type="Submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                        <!-- /.card -->
                    </form> --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <b>List Indikator</b>
                            </div>
                            @php
                                $hari = \Carbon\Carbon::now();
                                $jmlhari = \Carbon\Carbon::now()->daysInMonth;
                            @endphp
                        </div>
                        <div class="card-body">

                            <div style="overflow-x:auto;">
                                <table class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Nama Indikator</th>
                                            <th colspan="{{ $jmlhari }}" class="text-center">
                                                {{ \Carbon\Carbon::now()->locale('id')->monthName }}
                                                {{ \Carbon\Carbon::now()->locale('id')->year }}
                                            </th>
                                        </tr>
                                        <tr>
                                            @for ($i = 1; $i <= $jmlhari; $i++)
                                                @php
                                                    $tgl = \Carbon\Carbon::create($hari->year, $hari->month, $i, 0, 0, 0);
                                                    $hariini = $tgl->locale('id')->dayName;
                                                @endphp
                                                @if (($hariini == 'Sabtu') | ($hariini == 'Minggu'))
                                                    <th class="text-danger">{{ $i }}</th>
                                                @else
                                                    <th>{{ $i }}</th>
                                                @endif
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data2 as $main)
                                            <tr>
                                                <td>
                                                    <a href="/indikator/list/{{ Crypt::encrypt($main->id) }}"
                                                        data-toggle="tooltip" data-placement="right"
                                                        title="Klik untuk Input Data">{{ $main->nama }}</a>
                                                </td>

                                                @for ($n = 1; $n <= $jmlhari; $n++)
                                                    @php
                                                        $tgl = \Carbon\Carbon::create($hari->year, $hari->month, $n, 0, 0, 0);
                                                    @endphp
                                                    @if (!empty(\App\Nilai::list($main->id, $tgl)))
                                                        <td>
                                                            <a
                                                                href="/indikator/{{ Crypt::encrypt($main->id) }}/edit/{{ Crypt::encrypt($tgl) }}">
                                                                @if (!empty(\App\Nilai::list($main->id, $tgl)->nilai))
                                                                    {{ \App\Nilai::list($main->id, $tgl)->nilai }}{{ $main->satuan->nama }}
                                                                @else
                                                                    @php
                                                                        $nilai = (\App\Nilai::list($main->id, $tgl)->nilai_n / \App\Nilai::list($main->id, $tgl)->nilai_d) * 100;
                                                                    @endphp
                                                                    {{ number_format($nilai, 2) }}{{ $main->satuan->nama }}
                                                                @endif
                                                            </a>
                                                        </td>
                                                    @else
                                                        <td> -
                                                        </td>
                                                    @endif
                                                @endfor

                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                            <small>* Klik pada indikator untuk input nilai</small><br>
                            <small>* Klik pada nilai untuk edit nilai</small>
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
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('template/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        $(function() {
            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": false,
            });
        });
        //Date picker
        $('#tanggal').datetimepicker({
            format: 'DD-MM-YYYY'
        });
    </script>
@endsection
