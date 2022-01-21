@extends('layouts.master')

<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('content')
    <section class="content">
        <div class="container-fluid">

            <form role="form" action="/detail/update/{{ $data->id }}" method="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Indikator</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="card-body">
                        <div class="row">
                            <!-- text input -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Indikator</label>
                                    <textarea name="indikator" rows="1" class="form-control"
                                        required>{{ $data->nama }}</textarea>
                                    @if ($errors->has('indikator'))
                                        <div class="text-danger">
                                            {{ $errors->first('indikator') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Definisi Operational</label>
                                    <textarea name="do" rows="3" class="form-control"
                                        required>{{ $data->do }}</textarea>
                                    @if ($errors->has('do'))
                                        <div class="text-danger">
                                            {{ $errors->first('do') }}
                                        </div>
                                    @endif
                                </div>


                            </div>


                            <div class="col-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="form-control select2 " name="kategori" required>
                                        <option value="">Pilih</option>
                                        @foreach ($data2 as $list)
                                            <option value="{{ $list->id }}"
                                                {{ $data->kategori_id == $list->id ? 'selected' : '' }}>
                                                {{ $list->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('kategori'))
                                        <div class="text-danger">
                                            {{ $errors->first('kategori') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Sumber Data</label><small>* Optional</small>
                                    <div class="input-group mb-3">

                                        <input type="text" name="sumberdata" class="form-control"
                                            value="{{ $data->sumberdata }}" />
                                        {{-- <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div> --}}
                                    </div>
                                    @if ($errors->has('sumberdata'))
                                        <div class="text-danger">
                                            {{ $errors->first('sumberdata') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Numerator</label><small>* Optional</small>
                                    <div class="input-group mb-3">
                                        <input type="text" name="numerator" class="form-control"
                                            value="{{ $data->numerator }}" />
                                        {{-- <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div> --}}
                                    </div>
                                    @if ($errors->has('numerator'))
                                        <div class="text-danger">
                                            {{ $errors->first('numerator') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Frekuensi Pengumpulan Data</label>
                                    <select class="form-control select2 " name="pengumpulan" required>
                                        <option value="">Pilih</option>
                                        <option value="Harian" @if ($data->pengumpulan == 'Harian')
                                            selected
                                            @endif>Harian</option>
                                        <option value="Mingguan" @if ($data->pengumpulan == 'Mingguan')
                                            selected
                                            @endif>Mingguan</option>
                                        <option value="Bulanan" @if ($data->pengumpulan == 'Bulanan')
                                            selected
                                            @endif>Bulanan</option>
                                    </select>
                                    @if ($errors->has('pengumpulan'))
                                        <div class="text-danger">
                                            {{ $errors->first('pengumpulan') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Denumerator</label><small>* Optional</small>
                                    <div class="input-group mb-3">

                                        <input type="text" name="denumerator" class="form-control"
                                            value="{{ $data->denumerator }}" />
                                        {{-- <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div> --}}
                                    </div>
                                    @if ($errors->has('denumerator'))
                                        <div class="text-danger">
                                            {{ $errors->first('denumerator') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Periode Pelaporan</label>
                                    <select class="form-control select2 " name="pelaporan" required>
                                        <option value="">Pilih</option>
                                        <option value="Harian" @if ($data->pelaporan == 'Harian')
                                            selected
                                            @endif>Harian</option>
                                        <option value="Mingguan" @if ($data->pelaporan == 'Mingguan')
                                            selected
                                            @endif>Mingguan</option>
                                        <option value="Bulanan" @if ($data->pelaporan == 'Bulanan')
                                            selected
                                            @endif>Bulanan</option>
                                    </select>
                                    @if ($errors->has('pelaporan'))
                                        <div class="text-danger">
                                            {{ $errors->first('pelaporan') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Target</label>
                                    <div class="input-group mb-3">

                                        <input type="text" name="target" class="form-control" required
                                            value="{{ $data->target }}" />
                                        {{-- <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div> --}}
                                    </div>
                                    @if ($errors->has('target'))
                                        <div class="text-danger">
                                            {{ $errors->first('target') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <select class="form-control select2 " name="satuan" required>
                                        <option value="">Pilih</option>
                                        @foreach ($data3 as $list)
                                            <option value="{{ $list->id }}"
                                                {{ $data->satuan_id == $list->id ? 'selected' : '' }}>
                                                {{ $list->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('satuan'))
                                        <div class="text-danger">
                                            {{ $errors->first('satuan') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Bobot Penilaian</label>
                                    <div class="input-group mb-3">
                                        <input type="number" step="0.05" name="bobot" class="form-control" required
                                            value="{{ $data->bobot }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div>
                                    </div>
                                    @if ($errors->has('bobot'))
                                        <div class="text-danger">
                                            {{ $errors->first('bobot') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Catatan</label><small>* Optional</small>
                                    <textarea name="catatan" rows="4"
                                        class="form-control">{{ $data->catatan }}</textarea>
                                    @if ($errors->has('catatan'))
                                        <div class="text-danger">
                                            {{ $errors->first('catatan') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>PIC</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control" @if (!empty($data->user_id))
                                        value="{{ $data->user->name }}"
                                        @endif
                                        readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Pembaharuan Terakhir</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $data->updated_at }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- /.box-body -->
                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-default">Kembali</a>
                        <button type="submit" class="btn btn-primary">Perbaharui</button>
                    </div>

                </div>
            </form>

        </div>
    </section>
@endsection
