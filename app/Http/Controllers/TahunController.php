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
        $this->middleware('permission:tahun-list|tahun-create|tahun-edit|tahun-delete', ['only' => ['index']]);
        $this->middleware('permission:tahun-create', ['only' => ['store']]);
        $this->middleware('permission:tahun-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tahun-delete', ['only' => ['delete']]);
    }

    public function index()
    {
        session()->put('ibu', 'Master');
        session()->put('anak', 'Master Tahun');

        $data = Tahun::all();

        return view('masters.tahuns', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|unique:tahuns,nama',
            // 'keterangan' => 'required',
        ], [
            'nama.unique' => 'Tahun yang dimasukkan sudah digunakan!'
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
        return view('masters.tahuns_edit', ['data' => $data]);
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            'nama' => 'required|unique:tahuns,nama,' . $id,
            // 'keterangan' => 'required',
        ], [
            'nama.unique' => 'Tahun yang dimasukkan sudah digunakan!'
        ]);

        $unit = Tahun::find($id);
        $unit->nama = $request->nama;
        // $unit->keterangan = $request->keterangan;
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
