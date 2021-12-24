<?php

namespace App\Http\Controllers;

use App\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class SatuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        session()->put('ibu', 'Master');
        session()->put('anak', 'Master Satuan');

        $data = Satuan::all();

        return view('satuans', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|unique:satuans,nama',
            'keterangan' => 'required',
        ], [
            'nama.unique' => 'Satuan yang dimasukkan sudah digunakan!'
        ]);

        $unit = new Satuan();
        $unit->nama = $request->nama;
        $unit->keterangan = $request->keterangan;
        $unit->save();

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        return redirect('/satuan');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data = Satuan::find($id);
        return view('satuans_edit', ['data' => $data]);
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            'nama' => 'required',
            // 'keterangan' => 'required',
        ]);

        $unit = Satuan::find($id);
        $unit->nama = $request->nama;
        $unit->keterangan = $request->keterangan;
        $unit->save();

        Session::flash('sukses', 'Data Berhasil diperbaharui!');

        return redirect('/satuan');
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $tahun = Satuan::find($id);
        $tahun->delete();

        Session::flash('sukses', 'Data Berhasil dihapus!');

        return redirect('/satuan');
    }
}
