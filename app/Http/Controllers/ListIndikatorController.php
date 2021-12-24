<?php

namespace App\Http\Controllers;

use App\DetailIndikator;
use App\Indikator;
use App\Nilai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $hari = Carbon::now();
        $jmlhari = $hari->daysInMonth;

        $date1 = Carbon::create($hari->year, $hari->month, 1, 0, 0, 0);
        //dd($date1);

        if (empty($data)) {
            Session::flash('error', 'Belum ada indikator yang disetujui!');

            return redirect("/indikator");
        } else {
            $data2 = DetailIndikator::where('indikator_id', '=', $data->id)
                ->get();

            // $query =  Nilai::where('detail_indikator_id', '=', 1)
            //     ->orderBy('tanggal', 'ASC')
            //     ->get();

            // dd($query);

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

        if ($tanggal > Carbon::now()) {
            Session::flash('error', 'Data Tanggal tidak boleh melewati tanggal hari ini!');

            return redirect("/indikator/list");
        }

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