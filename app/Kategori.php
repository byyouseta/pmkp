<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama', 'keterangan'
    ];

    public function link()
    {
        return $this->hasOne('App\LinkIndikator');
    }

    public function subkategori()
    {
        return $this->hasMany('App\SubKategori');
    }
}
