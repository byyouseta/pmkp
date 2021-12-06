<?php

namespace App\Http\Controllers;

use App\DetailLokal;
use App\Lokal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class DetailLokalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        session()->put('ibu', 'Imut Lokal');
        session()->put('anak', 'Detail Imut Lokal');
        // Session::forget('anak');

        $id =  Crypt::decrypt($id);

        $data = Lokal::find($id);
        $data2 = DetailLokal::where('lokal_id', '=', $id)
            ->get();

        return view('detail_lokals', [
            'data' => $data,
            'data2' => $data2
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'indikator' => 'required',
            'target' => 'required|numeric',
            // 'keterangan' => 'required',
        ], [
            'target.numeric' => 'Target ditulis dengan format Angka!'
        ]);

        // dd($request);

        $detail = new DetailLokal();
        $detail->lokal_id = $request->id;
        $detail->nama = $request->indikator;
        $detail->target = $request->target;

        $detail->save();

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        $id = Crypt::encrypt($request->id);

        return redirect("/lokal/$id");
    }
}
