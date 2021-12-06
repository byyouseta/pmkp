<?php

namespace App\Http\Controllers;

use App\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class TahunController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        session()->put('ibu', 'Master');
        session()->put('anak', 'Master Unit');

        $data = Tahun::all();

        return view('tahuns', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            // 'keterangan' => 'required',
        ]);

        $unit = new Tahun();
        $unit->nama = $request->nama;
        // $unit->keterangan = $request->keterangan;
        $unit->save();

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        return redirect('/tahun');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data = Tahun::find($id);
        return view('tahuns_edit', ['data' => $data]);
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            'nama' => 'required',
            // 'keterangan' => 'required',
        ]);

        $unit = Tahun::find($id);
        $unit->nama = $request->nama;
        $unit->keterangan = $request->keterangan;
        $unit->save();

        Session::flash('sukses', 'Data Berhasil diperbaharui!');

        return redirect('/tahun');
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $tahun = Tahun::find($id);
        $tahun->delete();

        Session::flash('sukses', 'Data Berhasil dihapus!');

        return redirect('/tahun');
    }
}
