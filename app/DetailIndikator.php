<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailIndikator extends Model
{
    protected $fillable = [
        'nama', 'target', 'kategori_id', 'indikator_id'
    ];

    public function indikator()
    {
        return $this->belongsTo('App\Indikator');
    }

    public function kategori()
    {
        return $this->belongsTo('App\Kategori');
    }

    public function nilai()
    {
        return $this->hasMany('App\Nilai');
    }
}
