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
                    <form action="/indikator/list/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header"><b>Edit Data</b>
                                <div class="float-right">
                                    <a class="btn btn-secondary btn-sm" href="{{ url()->previous() }}"> Kembali</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if ($data->pelaporan != 'Bulanan')
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Tanggal</label>
                                        <input type="hidden" name="id" value="{{ $data2->id }}">
                                        <div class="col-sm-3 input-group date">
                                            <input type="text" class="form-control" name="tanggal"
                                                value="{{ \Carbon\Carbon::parse($data2->tanggal)->format('d-m-Y') }}"
                                                readonly />
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="id" value="{{ $data2->id }}">
                                    <input type="hidden" name="bulan" value="{{ $data2->tanggal }}">
                                @endif
                                @if (empty($data2->nilai_n) and empty($data2->nilai_d))
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nilai</label>
                                        <div class="col-sm-3 input-group">
                                            <input type="number" name="nilai" class="form-control"
                                                placeholder="Ketikkan Nilai sesuai Tanggal" value="{{ $data2->nilai }}"
                                                required autocomplete="off" @if ($data->satuan->nama == '%') max="100" @endif />
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ $data->satuan->nama }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @if (empty($data2->file))
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Data Pendukung</label>
                                            <div class="col-sm-5 input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile"
                                                        name="file">
                                                    <label class="custom-file-label" for="customFile">Pilih atau drop file
                                                        disini</label>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Data Pendukung</label>
                                            <div class="col-sm-5 col-form-label">
                                                <a href="/indikator/list/file/{{ $data2->file }}"
                                                    class="btn btn-success btn-sm" target="new_tab">Lihat</a>
                                                <a href="/indikator/list/destroy/{{ Crypt::encrypt($data2->id) }}"
                                                    class="btn btn-danger btn-sm delete-confirm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Hapus">
                                                    <i class="fas fa-times-circle"></i> Hapus
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nilai Numerator</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nilai_n" class="form-control"
                                                placeholder="{{ $data->numerator }}" value="{{ $data2->nilai_n }}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nilai Denumerator</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nilai_d" class="form-control"
                                                placeholder="{{ $data->denumerator }}" value="{{ $data2->nilai_d }}"
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
    <script>
        $(function() {
            bsCustomFileInput.init();

        });
    </script>
@endsection
