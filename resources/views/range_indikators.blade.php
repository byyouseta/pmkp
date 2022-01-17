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
                    @php
                        
                        $hariini = \Carbon\Carbon::now();
                        $jmlhari = \Carbon\Carbon::now()->daysInMonth;
                    @endphp
                    <form action="/range/store" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header"><b>Input Range Nilai</b>
                                <div class="float-right">
                                    <a class="btn btn-secondary btn-sm"
                                        href="/indikator/{{ Crypt::encrypt($data->indikator_id) }}">
                                        Kembali</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <div class="form-group row">
                                    {{-- <label class="col-sm-3">Range Nilai</label> --}}
                                    <div class="col-sm-4 input-group">
                                        <input type="text" name="awal" class="form-control" placeholder="Nilai Awal"
                                            value="{{ old('awal') }}" required />
                                        <div class="input-group-append">
                                            <div class="input-group-text">{{ $data->satuan->nama }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 input-group">
                                        <input type="text" name="akhir" class="form-control" placeholder="Nilai Akhir"
                                            value="{{ old('akhir') }}" required />
                                        <div class="input-group-append">
                                            <div class="input-group-text">{{ $data->satuan->nama }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="nilai" class="form-control" placeholder="Nilai"
                                            value="{{ old('nilai') }}" required />
                                    </div>
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
                            <div class="card-title"><b>Range Indikator</b></div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nilai Awal</th>
                                        <th>Nilai Akhir</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data2 as $list)
                                        <tr>
                                            <td>{{ $list->awal }} {{ $data->satuan->nama }}</td>
                                            <td>{{ $list->akhir }} {{ $data->satuan->nama }}</td>
                                            <td>{{ $list->nilai }}</td>
                                            <td>
                                                <a href="/range/delete/{{ Crypt::encrypt($list->id) }}"
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
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title"><b>Detail Indikator</b></div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 20%">Nama Indikator</th>
                                        <td>{{ $data->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Definisi Operasional</th>
                                        <td>{{ $data->do }}</td>
                                    </tr>
                                    <tr>
                                        <th>Frekuensi Pengumpulan Data</th>
                                        <td>{{ $data->pengumpulan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Periode Pelaporan</th>
                                        <td>{{ $data->pelaporan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Formula</th>
                                        <td>{{ $data->catatan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Numerator</th>
                                        <td>{{ $data->numerator }}</td>
                                    </tr>
                                    <tr>
                                        <th>Denumerator</th>
                                        <td>{{ $data->denumerator }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sumber Data</th>
                                        <td>{{ $data->sumberdata }}</td>
                                    </tr>
                                    <tr>
                                        <th>Target</th>
                                        <td>{{ $data->target }}{{ $data->satuan->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>PIC</th>
                                        <td>
                                            @if (!empty($data->user_id))
                                                {{ $data->user->name }}
                                            @endif
                                        </td>
                                    </tr>
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
@section('plugin')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('template/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
            //Date picker
            $('#tanggal').datetimepicker({
                format: 'DD-MM-YYYY'
            });
        });
    </script>

@endsection
