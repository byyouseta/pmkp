<?php

namespace App\Http\Controllers;

use App\DetailIndikator;
use App\Nilai;
use App\Tahun;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class IktController extends Controller
{
    public function index(Request $request)
    {
        session()->put('ibu', 'IKT');
        session()->put('anak', 'Rekap Bulanan IKT');
        // //Session::forget('anak');

        // dd($bulan, $tahun, $unit);
        // if (empty($unit)) {
        //     $unit = Auth::user()->unit_id;
        // } else {
        //     $unit = $request->input('unit');
        // }

        $unit = 45;

        if (empty($request->input('tahun'))) {
            $tahun = Carbon::now()->format('Y');
        } else {
            $tahun = $request->input('tahun');
        }

        if (empty($request->input('bulan'))) {
            $bulan = Carbon::now()->format('m');
        } else {
            $bulan = $request->input('bulan');
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

            return view('ikt.rekap_bulanan', compact('data', 'data2', 'data3'));
        } else {

            $data2 = DetailIndikator::where('indikator_id', '=', $data->id)
                ->where('pelaporan', 'Bulanan')
                ->where('kategori_id', '=', 6)
                ->get();

            // dd($data2);

            if ($data2->count() == 0) {
                Session::flash('error', 'Tidak ada data IKT pada unit, tanggal yang dipilih!');
            }

            $data = Tahun::all();
            $data3 = Unit::orderBy('nama', 'asc')->get();
            // dd($data2);

            return view('ikt.rekap_bulanan', compact('data', 'data2', 'data3'));
        }
    }

    public function pelaporan(Request $request)
    {

        if (empty($request->input('tahun'))) {
            $tahun = Carbon::now()->format('Y');
        } else {
            $tahun = $request->input('tahun');
        }

        $cek = DB::table('indikators')
            ->join('tahuns', 'indikators.tahun_id', '=', 'tahuns.id')
            ->select('indikators.*', 'tahuns.nama as tahun')
            ->where('indikators.status', '=', 3)
            ->where('indikators.unit_id', '=', Auth::user()->unit_id)
            ->where('tahuns.nama', '=', $tahun)
            ->first();

        if (empty($cek)) {
            Session::flash('error', 'Belum ada indikator yang disetujui pada tahun ' . $tahun);

            return redirect("/ikt/laporan");
        } else {
            $data2 = DetailIndikator::where('indikator_id', '=', $cek->id)
                ->where('pelaporan', '=', 'Bulanan')
                ->where('kategori_id', '=', 6)
                ->get();
        }

        $data = Tahun::all();

        return view('ikt.index', [
            'data' => $data,
            'data2' => $data2,
        ]);
    }

    public function inputlapor($id)
    {
        session()->put('ibu', 'IKT');
        session()->put('anak', 'Pelaporan Data');

        $id = Crypt::decrypt($id);

        $data = DetailIndikator::find($id);

        return view("ikt.pelaporan", compact('data'));
    }

    public function store(Request $request)
    {
        // $id = Crypt::decrypt($id);
        // dd($request);

        $this->validate($request, [
            'file' => 'mimes:pdf,jpg,jpeg|max:2048',
            // 'nilai' => 'max:3',
            'tanggal' => Rule::unique('nilais')->where(function ($query) use ($request) {
                return $query->where('detail_indikator_id', $request->id);
            }),

            // 'keterangan' => 'required',
        ], [
            'tanggal.unique' => 'Tanggal yang dipilih sudah ada nilainya!',
            // 'nilai.max' => 'Nilai yang dimasukkan melebihi ketentuan!',
            'file.mimes' => 'File yang diperbolehkan adalah file PDF, JPG/JPEG!',
            'file.max' => 'Ukuran file maksimal 2MB!'
        ]);

        if (!empty($request->bulan)) {
            $tanggal = \Carbon\Carbon::create(
                \Carbon\Carbon::parse($request->tanggal)->format('Y'),
                $request->bulan,
                1,
                0,
                0,
                0
            );
        } else {
            $tanggal = \Carbon\Carbon::create(
                \Carbon\Carbon::parse($request->tanggal)->format('Y'),
                \Carbon\Carbon::parse($request->tanggal)->format('m'),
                \Carbon\Carbon::parse($request->tanggal)->format('d'),
                0,
                0,
                0
            );
        }

        // dd($tanggal);

        $pengisian = Nilai::where('detail_indikator_id', '=', $request->id)
            ->whereMonth('tanggal', $tanggal->month)
            ->whereYear('tanggal', $tanggal->year)
            ->count();

        // dd($pengisian);
        //cek banyaknya inputan sesuai dengan pengumpulan
        $cek = DetailIndikator::find($request->id);
        if ($cek->pengumpulan == "Harian") {
            $maks = 23;
        } elseif ($cek->pengumpulan == "Mingguan") {
            $maks = $tanggal->weekOfMonth;
            // dd($maks);
        } else {
            $maks = 1;
        }

        //error jika melebihi maksimal pengitputan
        if ($pengisian > $maks) {
            Session::flash('error', 'Pengisian data melebihi kapasitas frekuensi pelaporan!');

            return redirect("/ikt/laporan");
        }

        //error jika tanggal melebihi hari ini
        if ($tanggal > Carbon::now()) {
            Session::flash('error', 'Data Tanggal tidak boleh melewati tanggal hari ini!');

            return redirect("/ikt/laporan");
        }

        $cek = Nilai::where('tanggal', $tanggal)
            ->where('detail_indikator_id', '=', $request->id)
            ->count();

        // for ($i = 0; $i < count($request->id); $i++) {
        //cek manual untuk validasi input tanggal per id indikator_detail
        // code below

        if ($cek > 0) {
            Session::flash('error', 'Data pada tanggal tersebut sudah dimasukkan');
        } else {

            $update = new Nilai();
            $update->tanggal = $tanggal;
            if (isset($request->nilai)) {
                $update->nilai = $request->nilai;
            } else {
                $update->nilai_n = $request->nilai_n;
                $update->nilai_d = $request->nilai_d;
            }
            if (!empty($request->file)) {
                //aksi file
                $file = $request->file('file');
                $random = Str::random(3);
                $extension = $file->getClientOriginalExtension();
                $nama_file = Carbon::now()->format('dmYHi') . "_" . $random . '.' . $extension;
                // isi dengan nama folder tempat kemana file diupload
                $tujuan_upload = 'bukti';

                // dd($nama_file);
                $file->move($tujuan_upload, $nama_file);

                $update->file = $nama_file;
            }
            $update->detail_indikator_id = $request->id;

            $update->save();

            Session::flash('sukses', 'Data telah berhasil disimpan');
        }

        return redirect("/ikt/laporan");
    }
}
