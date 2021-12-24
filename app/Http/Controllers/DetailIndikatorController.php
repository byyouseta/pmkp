<?php

namespace App\Http\Controllers;

use App\DetailIndikator;
use App\Indikator;
use App\Kategori;
use App\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class DetailIndikatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        session()->put('ibu', 'Indikator Mutu');
        session()->put('anak', 'Detail Indikator');
        // Session::forget('anak');

        $id =  Crypt::decrypt($id);

        $data = Indikator::find($id);
        $data2 = DetailIndikator::where('indikator_id', '=', $id)
            ->get();
        $data3 = Kategori::all();
        //data satuan
        $data4 = Satuan::all();

        return view('detail_indikators', [
            'data' => $data,
            'data2' => $data2,
            'data3' => $data3,
            'data4' => $data4,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'indikator' => 'required',
            'target' => 'required|numeric',
            'satuan' => 'required',
        ], [
            'target.numeric' => 'Target ditulis dengan format Angka!'
        ]);

        // dd($request);

        $detail = new DetailIndikator();
        $detail->indikator_id = $request->id;
        $detail->nama = $request->indikator;
        $detail->target = $request->target;
        $detail->satuan_id = $request->satuan;
        $detail->kategori_id = $request->kategori;
        $detail->catatan = $request->catatan;

        $detail->save();

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        $id = Crypt::encrypt($request->id);

        return redirect("/indikator/$id");
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data = DetailIndikator::find($id);
        $data2 = Kategori::all();
        return view('detail_indikators_edit', [
            'data' => $data,
            'data2' => $data2
        ]);
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            'indikator' => 'required',
            'target' => 'required|numeric',
        ]);

        $update = DetailIndikator::find($id);
        $update->nama = $request->indikator;
        $update->target = $request->target;
        $update->kategori_id = $request->kategori;
        $update->save();

        Session::flash('sukses', 'Data Berhasil diperbaharui!');

        $id = Crypt::encrypt($id);

        return redirect("/indikator/$id");
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $delete = DetailIndikator::find($id);
        $delete->delete();

        Session::flash('sukses', 'Data Berhasil dihapus!');

        $id = Crypt::encrypt($id);

        return redirect("/indikator/$id");
    }

    public function send($id)
    {
        $id = Crypt::decrypt($id);

        $update = Indikator::find($id);
        $update->status = 1;

        $update->save();

        Session::flash('sukses', 'Data berhasil dikirim ke Admin');

        $id = Crypt::encrypt($id);

        return redirect("/indikator/$id");
    }

    public function detail($id)
    {
        $id = Crypt::decrypt($id);

        $data = Indikator::find($id);
        $data2 = DetailIndikator::where('indikator_id', '=', $id)
            ->get();

        return view('approvaldetail_indikators', [
            'data' => $data,
            'data2' => $data2
        ]);
    }

    public function approved($id, Request $request)
    {
        // $id = Crypt::decrypt($id);

        $this->validate($request, [
            'catatan' => 'required',
            'status' => 'required',
            // 'keterangan' => 'required',
        ]);

        $update = Indikator::find($id);
        $update->status = $request->status;
        $update->catatan = $request->catatan;

        $update->save();

        Session::flash('sukses', 'Data telah berhasil disimpan');

        // $id = Crypt::encrypt($request->id);

        return redirect("/indikator/approval");
    }
}
