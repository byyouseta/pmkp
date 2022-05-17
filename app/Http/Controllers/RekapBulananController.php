<?php

namespace App\Http\Controllers;

use App\DetailIndikator;
use App\Tahun;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;

class RekapBulananController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:rekap-bulanan', ['only' => ['index', 'bulanan']]);
    }

    public function index()
    {
        session()->put('ibu', 'IKU');
        session()->put('anak', 'Rekap Nilai Bulanan');

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
        $data3 = Unit::orderBy('nama', 'asc')->get();
        $data2 = null;

        //     return view('rekap_nilais', compact('data', 'data2', 'data3'));
        // } else {
        //     Session::flash('error', 'Belum ada indikator pada tahun ini!');

        //     return redirect("/indikator");
        // }

        return view('rekap_bulanan', compact('data', 'data2', 'data3'));
    }

    public function bulanan(Request $request)
    {
        // session()->put('ibu', 'Indikator Mutu');
        // session()->put('anak', 'Rekap Nilai Harian');

        $this->validate($request, [
            'bulan' => 'required',
            //'username' => 'required|unique:users,username',
            'tahun' => 'required',
        ]);

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $unit = $request->input('unit');

        // dd($bulan, $tahun, $unit);
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
            Session::flash('error', 'Belum ada indikator yang disetujui pada Unit yang dipilih!');

            // return redirect('/report/bulanan');
            $data2 = null;

            $data = Tahun::all();
            $data3 = Unit::orderBy('nama', 'asc')->get();
            // dd($data2);

            return view('rekap_bulanan', compact('data', 'data2', 'data3'));
        } else {

            $data2 = DetailIndikator::where('indikator_id', '=', $data->id)
                ->where('pelaporan', 'Bulanan')
                ->where('kategori_id', '=', 10)
                ->get();

            $data = Tahun::all();
            $data3 = Unit::orderBy('nama', 'asc')->get();
            // dd($data2);

            return view('rekap_bulanan', compact('data', 'data2', 'data3'));
        }
    }

    public function cetak($idt, $idh, $id)
    {
        $id = Crypt::decrypt($id);
        // mengambil data id rapat

        $data = DB::table('indikators')
            ->join('tahuns', 'indikators.tahun_id', '=', 'tahuns.id')
            ->join('units', 'units.id', '=', 'indikators.unit_id')
            ->select('indikators.*', 'tahuns.nama as tahun', 'units.nama as nama_unit')
            ->where('status', '3')
            ->where('unit_id', '=', $id)
            ->where('tahuns.nama', '=', $idh)
            ->first();

        // dd($data);

        if (empty($data)) {
            Session::flash('error', 'Belum ada indikator yang disetujui pada Unit yang dipilih!');

            return redirect('/report/bulanan');
        } else {

            $data2 = DetailIndikator::where('indikator_id', '=', $data->id)
                ->where('pelaporan', 'Bulanan')
                // ->orWhere('pelaporan', 'Mingguan')
                ->get();

            $data3 = Carbon::create($idh, $idt, 1, 0, 0, 0);

            $pdf = PDF::loadview('cetak_rekap_bulanan', [
                'data' => $data,
                'data2' => $data2,
                'data3' => $data3
            ]);

            // (Optional) Setup the paper size and orientation
            $pdf->setPaper('folio', 'landscape');
            // $pdf->setOptions(['isRemoteEnabled' => true]);

            // Render the HTML as PDF
            //$pdf->render();

            return $pdf->stream();
        }
    }
}
