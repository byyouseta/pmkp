<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        session()->put('ibu', 'Master');
        session()->put('anak', 'Master Unit');

        $data = Unit::all();

        return view('units', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'keterangan' => 'required',
        ]);

        $unit = new Unit();
        $unit->nama = $request->nama;
        $unit->keterangan = $request->keterangan;
        $unit->save();

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        return redirect('/unit');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data = Unit::find($id);
        return view('units_edit', ['data' => $data]);
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            'nama' => 'required',
            'keterangan' => 'required',
        ]);

        $unit = Unit::find($id);
        $unit->nama = $request->nama;
        $unit->keterangan = $request->keterangan;
        $unit->save();

        Session::flash('sukses', 'Data Berhasil diperbaharui!');

        return redirect('/unit');
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $unit = Unit::find($id);
        $unit->delete();

        Session::flash('sukses', 'Data Berhasil dihapus!');

        return redirect('/unit');
    }
}
