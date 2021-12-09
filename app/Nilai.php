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
}
