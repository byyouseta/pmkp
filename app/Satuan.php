<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $fillable = [
        'nama', 'keterangan'
    ];

    public function detailindikator()
    {
        return $this->hasMany('App\DetailIndikator');
    }
}
