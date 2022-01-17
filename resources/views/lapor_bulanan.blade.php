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
                                    {{-- <div class="col-sm-2 col-form-label">
                                        <label>Tahun</label>
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
                                    </div> --}}
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
                                            <th colspan="12" class="text-center">
                                                {{ $hariini->locale('id')->year }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Jan</th>
                                            <th>Feb</th>
                                            <th>Mar</th>
                                            <th>Apr</th>
                                            <th>Mei</th>
                                            <th>Jun</th>
                                            <th>Jul</th>
                                            <th>Agu</th>
                                            <th>Sep</th>
                                            <th>Okt</th>
                                            <th>Nov</th>
                                            <th>Des</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data2 as $index => $list)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td><a href="/indikator/list/{{ Crypt::encrypt($list->id) }}"
                                                        data-toggle="tooltip" data-placement="right"
                                                        title="Klik untuk Input Data">{{ $list->nama }}
                                                    </a>
                                                </td>
                                                <td>{{ $list->kategori->nama }}</td>
                                                <td>{{ $list->target }} {{ $list->satuan->nama }}</td>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    @php
                                                        $tgl = \Carbon\Carbon::create($hari->year, $i, 1, 0, 0, 0);
                                                    @endphp
                                                    @if (!empty(\App\Nilai::list($list->id, $tgl)))
                                                        <td>
                                                            <a
                                                                href="/indikator/{{ Crypt::encrypt($list->id) }}/edit/{{ Crypt::encrypt($tgl) }}">
                                                                @if (!empty(\App\Nilai::list($list->id, $tgl)->nilai))
                                                                    {{ \App\Nilai::list($list->id, $tgl)->nilai }}{{ $list->satuan->nama }}
                                                                @else
                                                                    @php
                                                                        $nilai = (\App\Nilai::list($list->id, $tgl)->nilai_n / \App\Nilai::list($list->id, $tgl)->nilai_d) * 100;
                                                                    @endphp
                                                                    {{ number_format($nilai, 2) }}{{ $list->satuan->nama }}
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
                                <small>* Klik pada indikator untuk input nilai</small><br>
                                <small>* Klik pada nilai untuk edit nilai</small>
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