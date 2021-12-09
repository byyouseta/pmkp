<?php

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        session()->put('ibu', 'Master');
        session()->put('anak', 'Master Kategori Imut');

        $data = Kategori::all();

        return view('kategoris', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|unique:kategoris,nama',
            'keterangan' => 'required',
        ], [
            'nama.unique' => 'Nama Kategori sudah pernah digunakan!'
        ]);

        $update = new Kategori();
        $update->nama = $request->nama;
        $update->keterangan = $request->keterangan;
        $update->save();

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        return redirect('/kategori');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data = Kategori::find($id);
        return view('kategoris_edit', ['data' => $data]);
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            'nama' => 'required|unique:kategoris,nama,' . $id,
            'keterangan' => 'required',
        ]);

        $update = Kategori::find($id);
        $update->nama = $request->nama;
        $update->keterangan = $request->keterangan;
        $update->save();

        Session::flash('sukses', 'Data Berhasil diperbaharui!');

        return redirect('/kategori');
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $delete = Kategori::find($id);
        $delete->delete();

        Session::flash('sukses', 'Data Berhasil dihapus!');

        return redirect('/kategori');
    }
}
