<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kategori-list|kategori-create|kategori-edit|kategori-delete', ['only' => ['index']]);
        $this->middleware('permission:kategori-create', ['only' => ['store']]);
        $this->middleware('permission:kategori-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:kategori-delete', ['only' => ['delete']]);
    }

    public function index()
    {
        session()->put('ibu', 'Master');
        session()->put('anak', 'Master Kategori Imut');

        $data = Kategori::all();

        return view('masters.kategoris', compact('data'));
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
        return view('masters.kategoris_edit', ['data' => $data]);
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

    public function subkategori($id)
    {
        session()->put('ibu', 'Master');
        session()->put('anak', 'Kategori');

        $id = Crypt::decrypt($id);

        $data = Kategori::find($id);
        $data2 = SubKategori::where('kategori_id', $id)->get();

        return view('masters.sub_kategori', compact('data', 'data2'));
    }

    public function storesub(Request $request)
    {
        $this->validate($request, [
            'subkategori' => 'required|unique:sub_kategoris,nama',
        ], [
            'subkategori.unique' => 'Nama Sub Kategori sudah pernah digunakan!'
        ]);

        $update = new SubKategori();
        $update->nama = $request->subkategori;
        $update->kategori_id = $request->id;
        $update->save();

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        $id = Crypt::encrypt($request->id);

        return redirect("/subkategori/$id");
    }

    public function deletesub($id)
    {
        $id = Crypt::decrypt($id);
        $delete = SubKategori::find($id);
        $delete->delete();

        Session::flash('sukses', 'Data Berhasil dihapus!');

        return redirect()->back();
    }

    public function getSubKategori(Request $request)
    {

        // Fetch Employees by Departmentid
        $data = SubKategori::where('kategori_id', $request->get('id'))
            ->pluck('nama', 'id');

        return response()->json($data);
    }
}
