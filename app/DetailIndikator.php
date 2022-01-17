<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetailIndikator extends Model
{
    protected $fillable = [
        'nama', 'target', 'kategori_id', 'indikator_id', 'satuan_id', 'do', 'numerator', 'denumerator', 'pengumpulan', 'pelaporan', 'sumberdata', 'user_id'
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

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function nilai()
    {
        return $this->hasMany('App\Nilai');
    }

    public function range()
    {
        return $this->hasMany('App\Range');
    }
}
