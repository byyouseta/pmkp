@extends('layouts.master')

@section('head')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Tempusdominus|Datetime Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (Request::get('cari'))
                        @php
                            $cari = Request::get('cari');
                        @endphp
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <form action="/indikator/cari" method="GET">
                                <div class="form-group row">
                                    <div class="col-sm-5 col-form-label">
                                        <input type="text" class="form-control" name="cari" placeholder="nama indikator"
                                            @if (!empty($cari)) value="{{ $cari }}" @endif>
                                    </div>
                                    <div class="col-sm-1 col-form-label">
                                        <button type="Submit" class="btn btn-primary btn-block"><i
                                                class="fas fa-search"></i> Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div style="overflow-x:auto;">
                                <table class="table table-bordered table-hover" id="example2">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">No</th>
                                            <th class="align-middle">Nama Indikator</th>
                                            <th class="align-middle">Tahun</th>
                                            <th class="align-middle">Kategori</th>
                                            <th class="align-middle">Unit</th>
                                            <th class="align-middle">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $index => $list)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td>{{ $list->nama }}</td>
                                                <td>{{ $list->indikator->tahun->nama }}</td>
                                                <td>{{ $list->kategori->nama }}</td>
                                                <td>{{ $list->indikator->unit->nama }}</td>
                                                <td>
                                                    <a href="" class="btn btn-primary btn-sm" id="editCompany"
                                                        data-toggle="modal" data-target='#practice_modal'
                                                        data-id="{{ $list->id }}" data-toggle="tooltip"
                                                        data-placement="bottom" title="Link Indikator">
                                                        <i class="fas fa-link"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- <small>* Klik pada indikator untuk input nilai</small><br>
                                <small>* Klik pada nilai untuk edit nilai</small> --}}
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
                                        @foreach ($data3 as $data3)
                                            <option value="{{ $data3->id }}"
                                                {{ old('kategori') == $data3->id ? 'selected' : '' }}>
                                                {{ $data3->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Sub Kategori</label>
                                    <div class="input-group">
                                        <select class="form-control select2" name="subkategori" id="subkategori" disabled>
                                            <option value="">Pilih</option>
                                        </select>

                                    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
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
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": false,
            });
        });
        //Date picker
        $('#tanggal').datetimepicker({
            format: 'DD-MM-YYYY'
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
@endsection
