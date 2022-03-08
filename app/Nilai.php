<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $fillable = [
        'detail_indikator_id', 'tanggal', 'nilai'
    ];

    public function detailindikator()
    {
        return $this->belongsTo('App\DetailIndikator');
    }

    public static function list($id, $ids)
    {
        $query =  Nilai::where('detail_indikator_id', '=', $id)
            ->where('tanggal', '=', $ids)
            ->first();

        // $nilai = $query->nilai;
        // dd($query);
        // if (empty($query)) {
        //     $query = null;
        // }

        return $query;
    }

    public static function haper($id, $ids)
    {
        $query =  Nilai::where('detail_indikator_id', '=', $id)
            ->where('tanggal', '=', $ids)
            ->first();
        if ((!empty($query->nilai)) and ($query->nilai > 0)) {
            $nilai = $query->nilai;
        } elseif ((!empty($query->nilai)) and ($query->nilai > 0)) {
            $nilai = 0;
        } elseif (($query->nilai_n != 0) and ($query->nilai_d != 0)) {
            $nilai = number_format($query->nilai_n / $query->nilai_d, 2, '.', '');
            $nilai = $nilai * 100;
        } else {
            $nilai = 0;
        }

        // dd($nilai);

        $cek = Range::where('detail_indikator_id', '=', $id)
            ->where('awal', '<=', $nilai)
            ->where('akhir', '>=', $nilai)
            ->first();
        // dd($cek);

        return $cek;
    }
}
