<?php

namespace App\Http\Controllers;

use App\DetailIndikator;
use App\Indikator;
use App\Tahun;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RekapController extends Controller
{
    public function index()
    {
        session()->put('ibu', 'Indikator Mutu');
        session()->put('anak', 'Rekap Nilai');

        $hari = Carbon::now();
        $jmlhari = $hari->daysInMonth;

        //Scrip yang lama
        // $data = DB::table('indikators')
        //     ->join('tahuns', 'indikators.tahun_id', '=', 'tahuns.id')
        //     ->select('indikators.*', 'tahuns.nama as tahun')
        //     ->where('status', '3')
        //     ->where('unit_id', '=', Auth::user()->unit_id)
        //     ->where('tahuns.nama', '=', $hari->year)
        //     ->first();

        // $date1 = Carbon::create($hari->year, $hari->month, 1, 0, 0, 0);

        // if (!empty($data)) {
        //     $data2 = DetailIndikator::where('indikator_id', '=', $data->id)
        //         ->get();

        $data = Tahun::all();
        $data3 = Unit::all();
        $data2 = null;

        //     return view('rekap_nilais', compact('data', 'data2', 'data3'));
        // } else {
        //     Session::flash('error', 'Belum ada indikator pada tahun ini!');

        //     return redirect("/indikator");
        // }

        return view('rekap_nilais', compact('data', 'data2', 'data3'));
    }

    public function month(Request $request)
    {
        session()->put('ibu', 'Indikator Mutu');
        session()->put('anak', 'Rekap Nilai Bulanan');

        $this->validate($request, [
            'bulan' => 'required',
            //'username' => 'required|unique:users,username',
            'tahun' => 'required',
        ]);

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $unit = $request->input('unit');

        // dd($bulan, $tahun);
        if (empty($unit)) {
            $unit = Auth::user()->unit_id;
        }

        $data = DB::table('indikators')
            ->join('tahuns', 'indikators.tahun_id', '=', 'tahuns.id')
            ->select('indikators.*', 'tahuns.nama as tahun')
            ->where('status', '3')
            ->where('unit_id', '=', $unit)
            ->where('tahuns.nama', '=', $tahun)
            ->first();

        // dd($data);

        if (empty($data)) {
            Session::flash('error', 'Belum ada indikator yang disetujui pada tanggal yang dipilih!');

            return redirect("/indikator");
        } else {

            $data2 = DetailIndikator::where('indikator_id', '=', $data->id)
                ->get();

            $data = Tahun::all();
            $data3 = Unit::all();
            // dd($data2);

            return view('rekap_nilais', compact('data', 'data2', 'data3'));
        }
    }
}
