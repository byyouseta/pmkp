<?php

namespace App\Http\Controllers;

use App\DetailIndikator;
use App\Range;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class RangeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:satuan-list|satuan-create|satuan-edit|satuan-delete', ['only' => ['index']]);
    //     $this->middleware('permission:satuan-create', ['only' => ['store']]);
    //     $this->middleware('permission:satuan-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:satuan-delete', ['only' => ['delete']]);
    // }

    public function index($id)
    {
        // session()->put('ibu', 'Master');
        session()->put('anak', 'Range Indikator');

        $id = Crypt::decrypt($id);

        $data = DetailIndikator::find($id);
        $data2 = Range::where('detail_indikator_id', $id)
            ->get();

        return view('range_indikators', compact('data', 'data2'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'awal' => 'required',
            'akhir' => 'required',
            'nilai' => 'required',
            // 'keterangan' => 'required',
        ], [
            'nama.unique' => 'Tahun yang dimasukkan sudah digunakan!'
        ]);

        $data = new Range();
        $data->detail_indikator_id = $request->id;
        $data->awal = $request->awal;
        $data->akhir = $request->akhir;
        $data->nilai = $request->nilai;
        $data->save();

        $id = Crypt::encrypt($request->id);

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        return redirect("/detail/range/$id");
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $delete = Range::find($id);
        $delete->delete();

        Session::flash('sukses', 'Data Berhasil dihapus!');

        return redirect()->back();
    }
}
