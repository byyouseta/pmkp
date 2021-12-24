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
                    @if (Request::get('bulan'))
                        @php
                            $hariini = \Carbon\Carbon::create(Request::get('tahun'), Request::get('bulan'), 1, 0, 0, 0);
                            $jmlhari = $hariini->daysInMonth;
                        @endphp
                    @else
                        @php
                            
                            $hariini = \Carbon\Carbon::now();
                            $jmlhari = \Carbon\Carbon::now()->daysInMonth;
                        @endphp
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <form action="/indikator/report/month" method="GET">

                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label">
                                        <select class="form-control select2 " name="bulan" required>
                                            <option value="1" {{ $hariini->month == 1 ? 'selected' : '' }}>Januari
                                            </option>
                                            <option value="2" {{ $hariini->month == 2 ? 'selected' : '' }}>Februari
                                            </option>
                                            <option value="3" {{ $hariini->month == 3 ? 'selected' : '' }}>Maret</option>
                                            <option value="4" {{ $hariini->month == 4 ? 'selected' : '' }}>April</option>
                                            <option value="5" {{ $hariini->month == 5 ? 'selected' : '' }}>Mei</option>
                                            <option value="6" {{ $hariini->month == 6 ? 'selected' : '' }}>Juni</option>
                                            <option value="7" {{ $hariini->month == 7 ? 'selected' : '' }}>Juli</option>
                                            <option value="8" {{ $hariini->month == 8 ? 'selected' : '' }}>Agustus
                                            </option>
                                            <option value="9" {{ $hariini->month == 9 ? 'selected' : '' }}>September
                                            </option>
                                            <option value="10" {{ $hariini->month == 10 ? 'selected' : '' }}>Oktober
                                            </option>
                                            <option value="11" {{ $hariini->month == 11 ? 'selected' : '' }}>November
                                            </option>
                                            <option value="12" {{ $hariini->month == 12 ? 'selected' : '' }}>Desember
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-form-label">
                                        <select class="form-control select2 " name="tahun" required>
                                            @foreach ($data as $tahun)
                                                <option value="{{ $tahun->nama }}"
                                                    {{ $hariini->year == $tahun->nama ? 'selected' : '' }}>
                                                    {{ $tahun->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-form-label">
                                        <button type="Submit" class="btn btn-primary">Lihat</button>
                                    </div>
                                </div>
                            </form>
                            @if (Request::get('bulan'))
                                @php
                                    $hari = $hariini;
                                    
                                @endphp
                            @else
                                @php
                                    $hari = \Carbon\Carbon::now();
                                    
                                @endphp
                            @endif

                        </div>
                        <div class="card-body">
                            <div style="overflow-x:auto;">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="align-middle">No</th>
                                            <th rowspan="2" class="align-middle">Nama Indikator</th>
                                            <th rowspan="2" class="align-middle">Kategori</th>
                                            <th rowspan="2" class="align-middle">Target</th>
                                            <th rowspan="2" class="align-middle">Catatan</th>
                                            <th colspan="{{ $jmlhari }}" class="text-center">
                                                {{ $hariini->locale('id')->monthName }}
                                                {{ $hariini->locale('id')->year }}
                                            </th>
                                        </tr>
                                        <tr>
                                            @for ($i = 1; $i <= $jmlhari; $i++)
                                                @php
                                                    $tgl = \Carbon\Carbon::create($hari->year, $hari->month, $i, 0, 0, 0);
                                                    $hariini = $tgl->locale('id')->dayName;
                                                @endphp
                                                @if (($hariini == 'Sabtu') | ($hariini == 'Minggu'))
                                                    <th class="text-center text-danger">{{ $i }}</th>
                                                @else
                                                    <th class="text-center">{{ $i }}</th>
                                                @endif
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data2 as $index => $main)
                                            <tr>
                                                <td>
                                                    {{ ++$index }}
                                                </td>
                                                <td>
                                                    {{ $main->nama }}
                                                </td>
                                                <td>
                                                    {{ $main->kategori->nama }}
                                                </td>
                                                <td>
                                                    {{ $main->target }}{{ $main->satuan->nama }}
                                                </td>
                                                <td>
                                                    {{ $main->catatan }}
                                                </td>
                                                @for ($n = 1; $n <= $jmlhari; $n++)
                                                    @php
                                                        $tgl = \Carbon\Carbon::create($hari->year, $hari->month, $n, 0, 0, 0);
                                                    @endphp
                                                    @if (!empty(\App\Nilai::list($main->id, $tgl)))
                                                        <td>{{ \App\Nilai::list($main->id, $tgl)->nilai }}{{ $main->satuan->nama }}
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
