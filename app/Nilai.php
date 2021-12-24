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
}
