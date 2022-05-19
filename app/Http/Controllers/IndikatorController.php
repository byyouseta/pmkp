<?php

namespace App\Http\Controllers;

use App\DetailIndikator;
use App\Indikator;
use App\Kategori;
use App\Satuan;
use App\Tahun;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class IndikatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:indikator-list', ['only' => ['index']]);
        $this->middleware('permission:indikator-create', ['only' => ['store']]);
        $this->middleware('permission:approval-list', ['only' => ['approval']]);
    }

    public function index()
    {
        session()->put('ibu', 'Indikator');
        session()->put('anak', 'Pengajuan');
        //Session::forget('anak');


        $data2 = Tahun::all();
        //data Unit
        if (Auth::user()->akses === 1) {
            $data3 = Unit::all();
            $data = Indikator::all();
        } else {
            $unit = (Auth::user()->unit_id);
            $data3 = Unit::where('id', '=', $unit)->get();
            $data = Indikator::where('unit_id', '=', $unit)
                ->orderBy('tahun_id', 'desc')
                ->get();
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
        session()->put('ibu', 'Indikator');
        session()->put('anak', 'Persetujuan Indikator');
        // Session::forget('anak');

        // $data = Indikator::where('status', '1')
        //     ->orWhere('status', '2')
        //     ->get();
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

    public function cari(Request $request)
    {
        session()->put('ibu', 'Indikator');
        session()->put('anak', 'Cari Indikator');

        $cari = $request->get('cari');

        if (!empty($cari)) {
            $data = DetailIndikator::where('nama', 'like', "%$cari%")->get();
        } else {
            $data = DetailIndikator::all();
        }

        $data3 = Kategori::all();

        return view('indikator.cari_indikator', [
            'data' => $data,
            'data3' => $data3
        ]);
    }

    public function getIndikator(Request $request)
    {
        $data = [];
        $hari = Carbon::now();

        if ($request->has('q')) {
            $search = $request->q;
            // $data = DetailIndikator::where('nama', 'like', "%$search%")->get();
            $data = DB::table('indikators')
                ->join('tahuns', 'indikators.tahun_id', '=', 'tahuns.id')
                ->join('units', 'indikators.unit_id', '=', 'units.id')
                ->join('detail_indikators', 'indikators.id', '=', 'detail_indikators.indikator_id')
                ->leftJoin('satuans', 'detail_indikators.satuan_id', '=', 'satuans.id')
                ->leftJoin('kategoris', 'detail_indikators.kategori_id', '=', 'kategoris.id')
                ->select(
                    'detail_indikators.id',
                    'detail_indikators.do',
                    'detail_indikators.nama',
                    'detail_indikators.pengumpulan',
                    'detail_indikators.pelaporan',
                    'detail_indikators.target',
                    'detail_indikators.satuan_id',
                    'detail_indikators.kategori_id',
                    'detail_indikators.indikator_id',
                    'tahuns.nama as tahun',
                    'kategoris.nama as kategori',
                    'satuans.nama as satuan',
                    'units.nama as unit'
                )
                // ->where('detail_indikators.nama', 'like', "%$search%")
                ->where('tahuns.nama', '=', $hari->year)
                // ->select('detail_indikators.*')
                ->where('detail_indikators.nama', 'like', "%$search%")
                ->get();
        }

        return response()->json($data);
    }
}
