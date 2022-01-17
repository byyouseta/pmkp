<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Range extends Model
{

    protected $fillable = [
        'detail_indikator_id', 'awal', 'akhir', 'nilai'
    ];

    public function detailindikator()
    {
        return $this->belongsTo('App\DetailIndikator');
    }
}
