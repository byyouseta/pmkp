<?php

namespace App\Http\Controllers;

use App\DetailIndikator;
use App\Indikator;
use App\Nilai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use File;

class ListIndikatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        session()->put('ibu', 'Indikator');
        session()->put('anak', 'Penilaian Indikator');

        // $data = Indikator::where('status', '3')
        //     ->where('unit_id', '=', Auth::user()->unit_id)
        //     ->first();

        $hari = Carbon::now();
        $jmlhari = $hari->daysInMonth;

        $date1 = Carbon::create($hari->year, $hari->month, 1, 0, 0, 0);

        $data = DB::table('indikators')
            ->join('tahuns', 'indikators.tahun_id', '=', 'tahuns.id')
            ->select('indikators.*', 'tahuns.nama as tahun')
            ->where('indikators.status', '=', 3)
            ->where('indikators.unit_id', '=', Auth::user()->unit_id)
            ->where('tahuns.nama', '=', $hari->year)
            ->first();

        // dd($data);

        if (empty($data)) {
            Session::flash('error', 'Belum ada indikator yang disetujui pada tahun ' . $hari->year);

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

            return redirect("/indikator/list");
        }

        //error jika tanggal melebihi hari ini
        if ($tanggal > Carbon::now()) {
            Session::flash('error', 'Data Tanggal tidak boleh melewati tanggal hari ini!');

            return redirect("/indikator/list");
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
            if (!empty($request->nilai)) {
                $update->nilai = $request->nilai;
            } else {
                $update->nilai_n = $request->nilai_n;
                $update->nilai_d = $request->nilai_d;
            }
            if (!empty($request->file)) {
                //aksi file
                $file = $request->file('file');
                $random = Str::random(5);
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

        if (!empty($request->bulan)) {
            return redirect("/pelaporan/bulanan");
        } else {
            return redirect("/indikator/list");
        }
    }

    public function detail($id)
    {
        $id = Crypt::decrypt($id);

        $data = DetailIndikator::find($id);

        return view("listdetail_indikators", compact('data'));
    }

    public function edit($id, $idt)
    {
        $id = Crypt::decrypt($id);
        $tanggal = Crypt::decrypt($idt);

        // dd($id, $tanggal);

        $data2 =  Nilai::where('detail_indikator_id', '=', $id)
            ->where('tanggal', '=', $tanggal)
            ->first();

        $data = DetailIndikator::find($id);

        // dd($data, $data2);
        return view("listedit_indikators", compact('data', 'data2'));
    }

    public function update(Request $request)
    {
        // $tanggal = \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d');

        $update = Nilai::find($request->id);
        if (!empty($request->nilai)) {
            $update->nilai = $request->nilai;
        }
        if (!empty($request->nilai_n)) {
            $update->nilai_n = $request->nilai_n;
        }
        if (!empty($request->nilai_d)) {
            $update->nilai_d = $request->nilai_d;
        }
        if (!empty($request->file)) {
            //aksi file
            $file = $request->file('file');
            $random = Str::random(5);
            $extension = $file->getClientOriginalExtension();
            $nama_file = Carbon::now()->format('dmYHi') . "_" . $random . '.' . $extension;
            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'bukti';

            // dd($nama_file);
            $file->move($tujuan_upload, $nama_file);

            $update->file = $nama_file;
        }

        $update->save();

        Session::flash('sukses', 'Data telah berhasil diubah');

        if (!empty($request->bulan)) {
            return redirect("/pelaporan/bulanan");
        } else {
            return redirect("/indikator/list");
        }
    }

    public function show($file)
    {
        // Force download of the file
        $this->file_to_download   = 'bukti/' . $file;
        //return response()->streamDownload(function () {
        //    echo file_get_contents($this->file_to_download);
        //}, $file.'.pdf');
        return response()->file($this->file_to_download);
    }

    public function destroy($id)
    {
        // hapus file
        $id = Crypt::decrypt($id);

        $bukti = Nilai::find($id);

        // dd($bukti);
        File::delete('bukti/' . $bukti->file);

        // hapus data
        $bukti->file = null;
        $bukti->save();

        Session::flash('sukses', 'Data berhasil didelete');

        return redirect()->back();
    }
}
