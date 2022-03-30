<?php

namespace App\Http\Controllers;

use App\RangeIku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class RangeIkuController extends Controller
{
    public function index()
    {
        session()->put('ibu', 'Master');
        session()->put('anak', 'Master Range IKU');

        $data = RangeIku::all();

        return view('masters.rangeiku', compact('data'));
    }

    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'nama' => 'required|unique:satuans,nama',
        //     'keterangan' => 'required',
        // ], [
        //     'nama.unique' => 'Satuan yang dimasukkan sudah digunakan!'
        // ]);

        $unit = new RangeIku();
        $unit->awal = $request->awal;
        $unit->akhir = $request->akhir;
        $unit->nilai = $request->nilai;
        $unit->save();

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        return redirect('/rangeiku');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data = RangeIku::find($id);
        return view('masters.rangeiku_edit', ['data' => $data]);
    }

    public function update($id, Request $request)
    {

        // $this->validate($request, [
        //     'nama' => 'required',
        //     // 'keterangan' => 'required',
        // ]);

        $unit = RangeIku::find($id);
        $unit->awal = $request->awal;
        $unit->akhir = $request->akhir;
        $unit->nilai = $request->nilai;
        $unit->save();

        Session::flash('sukses', 'Data Berhasil diperbaharui!');

        return redirect('/rangeiku');
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $tahun = RangeIku::find($id);
        $tahun->delete();

        Session::flash('sukses', 'Data Berhasil dihapus!');

        return redirect('/rangeiku');
    }
}
