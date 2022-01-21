@extends('layouts.master')

@section('head')
    <!-- DataTables -->
    {{-- <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> --}}

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.bootstrap4.min.css">
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

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <strong>Indikator yang diajukan</strong>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- <table class="table table-bordered table-hover">
                                @foreach ($data2 as $data2)
                                    <tr class="thead-dark">
                                        <th>Kategori</th>
                                        <th colspan="2">{{ $data2->kategori->nama }}</th>
                                    </tr>
                                    <tr>
                                        <th>Indikator</th>
                                        <td colspan="2">{{ $data2->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Definisi Operational</th>
                                        <td colspan="2">{{ $data2->do }}</td>
                                    </tr>
                                    <tr>
                                        <th>Frekuensi Pengumpulan</th>
                                        <td colspan="2">{{ $data2->pengumpulan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Periode Pelaporan</th>
                                        <td colspan="2">{{ $data2->pelaporan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Numerator</th>
                                        <td colspan="2">{{ $data2->nilai_n }}</td>
                                    </tr>
                                    <tr>
                                        <th>Denumerator</th>
                                        <td colspan="2">{{ $data2->nilai_d }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sumber Data</th>
                                        <td colspan="2">{{ $data2->sumber }}</td>
                                    </tr>
                                    <tr>
                                        <th>Target</th>
                                        <td colspan="2">{{ $data2->target }}</td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td colspan="2">{{ $data2->catatan }}</td>
                                    </tr>
                                    <tr>
                                        @if (!empty($data2->range->count()))
                                            <th rowspan="{{ $data2->range->count() }}">Range</th>
                                            @foreach ($data2->range as $rangelist)
                                                <td>{{ $rangelist->awal }}{{ $data2->satuan->nama }} -
                                                    {{ $rangelist->akhir }}{{ $data2->satuan->nama }}</td>
                                                <td>{{ $rangelist->nilai }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th>Range</th>
                                    <td colspan="2"> - </td>
                                </tr>
                                @endif

                                <tr>
                                    <th>PIC</th>
                                    <td colspan="2">{{ $data2->user->name }}</td>
                                </tr>
                                @endforeach
                            </table> --}}
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
                                        <th>Bobot</th>
                                        <th>Range</th>
                                        <th>PIC</th>
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
                                            <td>{{ $data2->target }}
                                                {{ $data2->satuan->nama }}</td>
                                            <td>{{ $data2->bobot }}%</td>

                                            {{-- <td>
                                                @php
                                                    $paragraphs = explode(PHP_EOL, $data2->catatan);
                                                @endphp
                                                @foreach ($paragraphs as $paragraph)
                                                    <p>{{ $paragraph }}</p>
                                                @endforeach
                                            </td> --}}

                                            <td>
                                                @forelse ($data2->range as $rangelist)
                                                    {{ $rangelist->nilai }}
                                                    ({{ $rangelist->awal }}{{ $data2->satuan->nama }} -
                                                    {{ $rangelist->akhir }}{{ $data2->satuan->nama }})
                                                    <br>
                                                @empty
                                                    -
                                                @endforelse
                                            </td>
                                            <td>
                                                @if (!empty($data2->user_id))
                                                    {{ $data2->user->name }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <strong>Persetujuan</strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="/indikator/approval/{{ $data->id }}" method="POST">
                                <div class="row">
                                    @csrf
                                    <div class="col-6">

                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <textarea name="catatan" rows="5" class="form-control"
                                                required>{{ $data->catatan }}</textarea>
                                            @if ($errors->has('catatan'))
                                                <div class="text-danger">
                                                    {{ $errors->first('catatan') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2 " name="status" required>
                                                <option value="">Pilih</option>
                                                <option value="2" {{ $data->status == 2 ? 'selected' : '' }}>
                                                    Revisi
                                                </option>
                                                <option value="3" {{ $data->status == 3 ? 'selected' : '' }}>
                                                    Disetujui
                                                </option>
                                            </select>
                                            @if ($errors->has('status'))
                                                <div class="text-danger">
                                                    {{ $errors->first('status') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card-footer"> --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="Submit" class="btn btn-primary pull-right">Simpan</button>
                                    </div>
                                </div>
                                {{-- </div> --}}
                            </form>
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
    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>

    <script>
        $(function() {
            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
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
