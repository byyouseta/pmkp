@extends('layouts.master')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Dashboard</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            Selamat Datang, {{ Auth::user()->name }}. Anda telah masuk ke aplikasi sebagai
                            {{ Auth::user()->getRoleNames() }} Unit/Poli {{ Auth::user()->unit->nama }}.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
