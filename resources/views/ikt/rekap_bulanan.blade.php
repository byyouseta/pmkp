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
                            <form action="/ikt/" method="GET">

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

                                    <div class="col-sm-1 col-form-label">
                                        <button type="Submit" class="btn btn-primary btn-block">Lihat</button>
                                    </div>
                                    @if (!empty(Request::get('bulan')))
                                        <div class="col-sm-1 col-form-label">
                                            <a href="/report/{{ Request::get('bulan') }}/bulanan/{{ Request::get('tahun') }}/{{ Crypt::encrypt(Request::get('unit')) }}"
                                                class="btn btn-secondary btn-block" target="_blank"><i
                                                    class="fas fa-print"></i>
                                                Print</a>
                                        </div>
                                    @endif
                                </div>
                            </form>

                        </div>
                        <div class="card-body">
                            <div style="overflow-x:auto;">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center align-middle">No</th>
                                            <th class="text-center align-middle" style="width: 20%">Indikator Kinerja</th>
                                            <th class="text-center align-middle" style="width: 50px">Satuan</th>
                                            <th class="text-center align-middle">Target (/Bulan)</th>
                                            <th class="text-center align-middle">Bobot (%)</th>
                                            <th class="text-center align-middle" style="width: 200px">Range</th>
                                            <th class="text-center align-middle">Capaian</th>
                                            <th class="text-center align-middle">Haper</th>
                                            <th class="text-center align-middle">Haper*Bobot</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalpersen = 0;
                                        @endphp
                                        @if (!empty($data2))
                                            @foreach ($data2 as $index => $list)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>{{ $list->nama }}</td>
                                                    <td class="text-center">{{ $list->satuan->keterangan }}</td>
                                                    <td class="text-center">{{ $list->target }}</td>
                                                    <td class="text-center">{{ $list->bobot }}%</td>
                                                    <td>
                                                        @foreach ($list->range as $rangelist)
                                                            @if ($list->satuan->posisi == 'Diawal')
                                                                ({{ $list->satuan->nama }}
                                                                {{ $rangelist->awal }}-{{ $list->satuan->nama }}
                                                                {{ $rangelist->akhir }})
                                                                {{ $rangelist->nilai }}
                                                            @else
                                                                ({{ $rangelist->awal }}
                                                                {{ $list->satuan->nama }}-{{ $rangelist->akhir }}
                                                                {{ $list->satuan->nama }})
                                                                {{ $rangelist->nilai }}
                                                            @endif
                                                            <br>
                                                        @endforeach
                                                    </td>
                                                    @php
                                                        $tgl = \Carbon\Carbon::create(Request::get('tahun'), Request::get('bulan'), 1, 0, 0, 0);
                                                    @endphp
                                                    @if (!empty(\App\Nilai::list($list->id, $tgl)))
                                                        <td>
                                                            @if (!empty(\App\Nilai::list($list->id, $tgl)->nilai))
                                                                @php
                                                                    if (\App\Nilai::list($list->id, $tgl)->nilai != 0) {
                                                                        $nilai = \App\Nilai::list($list->id, $tgl)->nilai;
                                                                    } else {
                                                                        $nilai = 0;
                                                                    }
                                                                @endphp

                                                                @if ($list->satuan->posisi == 'Diawal')
                                                                    {{ $list->satuan->nama }}
                                                                    {{ $nilai }}
                                                                @else
                                                                    {{ $nilai }}
                                                                    {{ $list->satuan->nama }}
                                                                @endif
                                                                @if (!empty(\App\Nilai::list($list->id, $tgl)->file))
                                                                    <a href="/indikator/list/file/{{ \App\Nilai::list($list->id, $tgl)->file }}"
                                                                        class="btn btn-success btn-sm"
                                                                        target="new_tab">Bukti</a>
                                                                @endif
                                                            @else
                                                                @php
                                                                    if (\App\Nilai::list($list->id, $tgl)->nilai_n != 0 and \App\Nilai::list($list->id, $tgl)->nilai_d != 0) {
                                                                        $nilai = (\App\Nilai::list($list->id, $tgl)->nilai_n / \App\Nilai::list($list->id, $tgl)->nilai_d) * 100;
                                                                    } else {
                                                                        $nilai = 0;
                                                                    }
                                                                @endphp

                                                                @if ($list->satuan->posisi == 'Diawal')
                                                                    {{ $list->satuan->nama }}
                                                                    {{ number_format($nilai, 2) }}
                                                                @else
                                                                    {{ number_format($nilai, 2) }}
                                                                    {{ $list->satuan->nama }}
                                                                @endif
                                                                @if (!empty(\App\Nilai::list($list->id, $tgl)->file))
                                                                    <a href="/indikator/list/file/{{ \App\Nilai::list($list->id, $tgl)->file }}"
                                                                        class="btn btn-success btn-sm"
                                                                        target="new_tab">Bukti</a>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td> -
                                                        </td>
                                                    @endif
                                                    @if (!empty(\App\Nilai::list($list->id, $tgl)))
                                                        @if ($list->range->count() > 0)
                                                            <td>
                                                                @if (!empty(\App\Nilai::haper($list->id, $tgl)->nilai))
                                                                    {{ \App\Nilai::haper($list->id, $tgl)->nilai }}
                                                                @else
                                                                    Nilai tidak ada dalam range
                                                                @endif

                                                            </td>
                                                        @else
                                                            <td>
                                                                Range tidak ada
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td> -
                                                        </td>
                                                    @endif
                                                    @if (!empty(\App\Nilai::list($list->id, $tgl)) && !empty(\App\Nilai::haper($list->id, $tgl)))
                                                        @php
                                                            $persentase = (\App\Nilai::haper($list->id, $tgl)->nilai * $list->bobot) / 100;
                                                            $totalpersen = $totalpersen + $persentase;
                                                        @endphp
                                                        <td>
                                                            {{ $persentase }}
                                                        </td>
                                                    @else
                                                        <td> -
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="16" class="text-center">Data tidak ditemukan</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                    @if ($totalpersen > 0)
                                        <tfoot>
                                            <tr>
                                                <td colspan="8" class="font-weight-bold text-right">Total
                                                </td>
                                                <td class="font-weight-bold">{{ $totalpersen }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" class="font-weight-bold text-right">IKU
                                                </td>
                                                <td class="font-weight-bold">{{ \App\RangeIku::nilaiiku($totalpersen) }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    @endif
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
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
        //Date picker
        $('#tanggal').datetimepicker({
            format: 'DD-MM-YYYY'
        });
    </script>
@endsection
