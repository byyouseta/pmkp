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

        return $query;
    }

    public static function haper($id, $ids)
    {
        $query =  Nilai::where('detail_indikator_id', '=', $id)
            ->where('tanggal', '=', $ids)
            ->first();
        if (!empty($query->nilai)) {
            $nilai = $query->nilai;
        } else {
            $nilai = number_format($query->nilai_n / $query->nilai_d, 2, '.', '');
            $nilai = $nilai * 100;
        }

        $cek = Range::where('detail_indikator_id', '=', $id)
            ->where('awal', '<=', $nilai)
            ->where('akhir', '>=', $nilai)
            ->first();
        // dd($query);

        return $cek;
    }
}
