<?php

namespace App\Http\Controllers;

use App\Indikator;
use App\Satuan;
use App\Tahun;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class IndikatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        session()->put('ibu', 'Indikator Mutu');
        session()->put('anak', 'Pengajuan');
        //Session::forget('anak');

        $data = Indikator::all();
        $data2 = Tahun::all();
        //data Unit
        if (Auth::user()->akses === 1) {
            $data3 = Unit::all();
        } else {
            $unit = (Auth::user()->unit_id);
            $data3 = Unit::where('id', '=', $unit)->get();
            // dd($data3);
        }


        return view('indikators', [
            'data' => $data,
            'data2' => $data2,
            'data3' => $data3,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required',
            'unit_id' => Rule::unique('indikators')->where(function ($query) use ($request) {
                return $query->where('tahun_id', $request->tahun);
            }),
            // 'keterangan' => 'required',
        ], [
            'unit_id.unique' => 'Imut Unit sudah ditambahkan dalam periode Tahun yang sama!'
        ]);

        $lokal = new Indikator();
        $lokal->tahun_id = $request->tahun;
        $lokal->unit_id = $request->unit_id;
        $lokal->keterangan = $request->keterangan;
        $lokal->status = 0;
        $lokal->user_id = Auth::user()->id;
        $lokal->save();

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        return redirect('/indikator');
    }

    public function approval()
    {
        session()->put('ibu', 'Indikator Mutu');
        session()->put('anak', 'Persetujuan Indikator Mutu');
        // Session::forget('anak');

        // $data = Lokal::where('status', '1')->get();
        $data = Indikator::all();
        // $data2 = Tahun::all();
        // if (Auth::user()->akses === 1) {
        //     $data3 = Unit::all();
        // } else {
        //     $unit = (Auth::user()->unit_id);
        //     $data3 = Unit::where('id', '=', $unit)->get();
        //     // dd($data3);
        // }

        return view('approval_indikators', [
            'data' => $data,
            // 'data2' => $data2,
            // 'data3' => $data3
        ]);
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

        $unit = Lokal::find($id);
        $unit->nama = $request->nama;
        $unit->keterangan = $request->keterangan;
        $unit->save();

        Session::flash('sukses', 'Data Berhasil diperbaharui!');

        return redirect('/lokal');
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $lokal = Lokal::find($id);
        $lokal->delete();

        Session::flash('sukses', 'Data Berhasil dihapus!');

        return redirect('/lokal');
    }
}
