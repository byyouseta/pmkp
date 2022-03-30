@extends('layouts.master')

<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('content')
    <section class="content">
        <div class="container-fluid">

            <form role="form" action="/rangeiku/update/{{ $data->id }}" method="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Range</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="card-body">
                        <div class="row">
                            <!-- text input -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nilai Awal</label>
                                    <input type="number" class="form-control" name="awal" value="{{ $data->awal }}"
                                        required />
                                    @error('awal')
                                        <span class="invalid-feedback text-red" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Nilai Akhir</label>
                                    <input type="number" class="form-control" name="akhir" value="{{ $data->akhir }}"
                                        required />
                                    @error('akhir')
                                        <span class="invalid-feedback text-red" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Nilai</label>
                                    <input type="number" step=".01" max="1" class="form-control" name="nilai"
                                        value="{{ $data->nilai }}" required />
                                    @error('nilai')
                                        <span class="invalid-feedback text-red" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Pembaharuan Terakhir</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $data->updated_at }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Dibuat</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control" name="created_at"
                                            value="{{ $data->created_at }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- /.box-body -->
                    <div class="card-footer">
                        <a href="/rangeiku" class="btn btn-default">Kembali</a>
                        <button type="submit" class="btn btn-primary">Perbaharui</button>
                    </div>

                </div>
            </form>

        </div>
    </section>
@endsection
