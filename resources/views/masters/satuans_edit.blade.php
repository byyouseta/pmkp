@extends('layouts.master')

<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('content')
    <section class="content">
        <div class="container-fluid">

            <form role="form" action="/satuan/update/{{ $data->id }}" method="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Satuan</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="card-body">
                        <div class="row">
                            <!-- text input -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nama Satuan</label>
                                    <input type="text" class="form-control" placeholder="Masukkan Nama Satuan" name="nama"
                                        value="{{ $data->nama }}">
                                    @if ($errors->has('nama'))
                                        <div class="text-danger">
                                            {{ $errors->first('nama') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Penulisan Satuan</label>
                                    <select class="form-control" name="posisi">
                                        <option value="Diawal" @if ($data->posisi == 'Diawal') selected @endif>Diawal
                                        </option>
                                        <option value="Diakhir" @if ($data->posisi == 'Diakhir') selected @endif>Diakhir
                                        </option>
                                    </select>
                                    @if ($errors->has('posisi'))
                                        <div class="text-danger">
                                            {{ $errors->first('posisi') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" rows="3" placeholder="Masukkan Keterangan"
                                        name="keterangan">{{ $data->keterangan }}</textarea>
                                    @if ($errors->has('keterangan'))
                                        <div class="text-danger">
                                            {{ $errors->first('keterangan') }}
                                        </div>
                                    @endif
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
                        <a href="/satuan" class="btn btn-default">Kembali</a>
                        <button type="submit" class="btn btn-primary">Perbaharui</button>
                    </div>

                </div>
            </form>

        </div>
    </section>
@endsection
