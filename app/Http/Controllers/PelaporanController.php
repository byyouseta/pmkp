<?php

namespace App\Http\Controllers;

use App\DetailIndikator;
use App\Tahun;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PelaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pelaporan-bulanan-list', ['only' => ['index']]);
    }

    public function index()
    {
        session()->put('ibu', 'Pelaporan Bulanan');
        session()->put('anak', '');

        // $data = Indikator::where('status', '3')
        //     ->where('unit_id', '=', Auth::user()->unit_id)
        //     ->first();

        $hari = Carbon::now();
        // $jmlhari = $hari->daysInMonth;

        // $date1 = Carbon::create($hari->year, $hari->month, 1, 0, 0, 0);

        $cek = DB::table('indikators')
            ->join('tahuns', 'indikators.tahun_id', '=', 'tahuns.id')
            ->select('indikators.*', 'tahuns.nama as tahun')
            ->where('indikators.status', '=', 3)
            ->where('indikators.unit_id', '=', Auth::user()->unit_id)
            ->where('tahuns.nama', '=', $hari->year)
            ->first();

        // dd($data);

        if (empty($cek)) {
            Session::flash('error', 'Belum ada indikator yang disetujui pada tahun ' . $hari->year);

            return redirect("/indikator");
        } else {
            $data2 = DetailIndikator::where('indikator_id', '=', $cek->id)
                ->where('pelaporan', '=', 'Bulanan')
                ->where('kategori_id', '=', 10)
                ->get();
        }
        // $query =  Nilai::where('detail_indikator_id', '=', 1)
        //     ->orderBy('tanggal', 'ASC')
        //     ->get();

        // dd($data2);

        $data = Tahun::all();

        return view('lapor_bulanan', [
            'data' => $data,
            'data2' => $data2,
        ]);


        // dd($data, $data2);
    }

    public function cari(Request $request)
    {
        $tahun = $request->input('tahun');
        // $jmlhari = $hari->daysInMonth;

        // $date1 = Carbon::create($hari->year, $hari->month, 1, 0, 0, 0);

        $cek = DB::table('indikators')
            ->join('tahuns', 'indikators.tahun_id', '=', 'tahuns.id')
            ->select('indikators.*', 'tahuns.nama as tahun')
            ->where('indikators.status', '=', 3)
            ->where('indikators.unit_id', '=', Auth::user()->unit_id)
            ->where('tahuns.nama', '=', $tahun)
            ->first();

        // dd($data);

        if (empty($cek)) {
            Session::flash('error', 'Belum ada indikator yang disetujui pada tahun ' . $tahun);

            return redirect("/pelaporan/bulanan");
        } else {
            $data2 = DetailIndikator::where('indikator_id', '=', $cek->id)
                ->where('pelaporan', '=', 'Bulanan')
                ->where('kategori_id', '=', 10)
                ->get();
        }
        // $query =  Nilai::where('detail_indikator_id', '=', 1)
        //     ->orderBy('tanggal', 'ASC')
        //     ->get();

        // dd($data2);

        $data = Tahun::all();

        return view('lapor_bulanan', [
            'data' => $data,
            'data2' => $data2,
        ]);
    }
}
