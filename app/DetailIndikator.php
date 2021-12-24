<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetailIndikator extends Model
{
    protected $fillable = [
        'nama', 'target', 'kategori_id', 'indikator_id', 'satuan_id'
    ];

    public function indikator()
    {
        return $this->belongsTo('App\Indikator');
    }

    public function kategori()
    {
        return $this->belongsTo('App\Kategori');
    }

    public function satuan()
    {
        return $this->belongsTo('App\Satuan');
    }

    public function nilai()
    {
        return $this->hasMany('App\Nilai');
    }
}
