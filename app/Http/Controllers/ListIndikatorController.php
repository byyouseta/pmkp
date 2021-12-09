<?php

namespace App\Http\Controllers;

use App\DetailIndikator;
use App\Indikator;
use App\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ListIndikatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        session()->put('ibu', 'Indikator Mutu');
        session()->put('anak', 'Pengisian Imut');

        $data = Indikator::where('status', '3')
            ->where('unit_id', '=', Auth::user()->unit_id)
            ->first();

        //dd($data);

        if (empty($data)) {
            Session::flash('error', 'Belum ada indikator yang disetujui!');

            return redirect("/indikator");
        } else {
            $data2 = DetailIndikator::where('indikator_id', '=', $data->id)
                ->get();

            //dd($data2);

            return view('list_indikators', compact('data', 'data2'));
        }

        // dd($data, $data2);
    }

    public function store(Request $request)
    {
        // $id = Crypt::decrypt($id);

        $this->validate($request, [
            'tanggal' => Rule::unique('nilais')->where(function ($query) use ($request) {
                return $query->where('detail_indikator_id', $request->id);
            }),
            'nilai' => 'required',
            // 'keterangan' => 'required',
        ]);

        //dd(count($request->id));
        $tanggal = \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d');

        for ($i = 0; $i < count($request->id); $i++) {
            //cek manual untuk validasi input tanggal per id indikator_detail
            // code below
            $cek = Nilai::where('tanggal', $tanggal)
                ->where('detail_indikator_id', '=', $request->id[$i])
                ->count();
            if ($cek > 0) {

                Session::flash('error', 'Data pada tanggal tersebut sudah dimasukkan');
            } else {
                // dd($cek);
                $update = new Nilai();
                $update->tanggal = $tanggal;
                $update->nilai = $request->nilai[$i];
                $update->detail_indikator_id = $request->id[$i];

                $update->save();

                Session::flash('sukses', 'Data telah berhasil disimpan');
            }
        }
        // $id = Crypt::encrypt($request->id);

        return redirect("/indikator/list");
    }
}
