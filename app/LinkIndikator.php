<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkIndikator extends Model
{
    protected $fillable = [
        'detail_indikator_id', 'indikator_id', 'kategori_id'
    ];

    public function detailindikator()
    {
        return $this->belongsTo('App\DetailIndikator', 'detail_indikator_id', 'id');
    }

    public function indikator()
    {
        return $this->belongsTo('App\Indikator');
    }

    public function kategori()
    {
        return $this->belongsTo('App\Kategori');
    }

    public function subkategori()
    {
        return $this->belongsTo('App\SubKategori');
    }
}
