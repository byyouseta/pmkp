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
                    <form action="/ikt/store" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header"><b>Input Data</b>
                                <div class="float-right">
                                    <a class="btn btn-secondary btn-sm" href="{{ url()->previous() }}"> Kembali</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if ($data->pelaporan != 'Bulanan')
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Tanggal</label>

                                        <div class="col-sm-3 input-group date" id="tanggal" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                data-target="#tanggal" name="tanggal" value="{{ old('tanggal') }}"
                                                data-toggle="datetimepicker" autocomplete="off" placeholder="Pilih Tanggal"
                                                required />
                                            <div class="input-group-append" data-target="#tanggal"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Bulan</label>

                                        <div class="col-sm-2 input-group date">
                                            <select class="form-control select2 " name="bulan" required>
                                                <option value="1" {{ $hariini->month == 1 ? 'selected' : '' }}>Januari
                                                </option>
                                                <option value="2" {{ $hariini->month == 2 ? 'selected' : '' }}>Februari
                                                </option>
                                                <option value="3" {{ $hariini->month == 3 ? 'selected' : '' }}>Maret
                                                </option>
                                                <option value="4" {{ $hariini->month == 4 ? 'selected' : '' }}>April
                                                </option>
                                                <option value="5" {{ $hariini->month == 5 ? 'selected' : '' }}>Mei
                                                </option>
                                                <option value="6" {{ $hariini->month == 6 ? 'selected' : '' }}>Juni
                                                </option>
                                                <option value="7" {{ $hariini->month == 7 ? 'selected' : '' }}>Juli
                                                </option>
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
                                    </div>
                                @endif
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                @if (empty($data->denumerator) and empty($data->numerator))
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Capaian</label>
                                        <div class="col-sm-3 input-group">
                                            <input type="number" name="nilai" class="form-control" step="any"
                                                placeholder="Ketikkan Nilai sesuai Tanggal" value="{{ old('nilai') }}"
                                                required autocomplete="off"
                                                @if ($data->satuan->nama == '%') max="100" @endif />
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ $data->satuan->nama }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Data Pendukung</label>
                                        <div class="col-sm-5 input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile" name="file">
                                                <label class="custom-file-label" for="customFile">Pilih atau drop file
                                                    disini</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-5 input-group">
                                            <small>* File dalam bentuk PDF/JPEG/JPG Maksimal 2Mb</small>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nilai Numerator</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nilai_n" class="form-control"
                                                placeholder="{{ $data->numerator }}" value="{{ old('nilai_n') }}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nilai Denumerator</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nilai_d" class="form-control"
                                                placeholder="{{ $data->denumerator }}" value="{{ old('nilai_d') }}"
                                                required />

                                        </div>
                                    </div>
                                @endif

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="Submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                        <!-- /.card -->
                    </form>

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
