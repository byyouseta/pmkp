<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubKategori extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kategori_id', 'nama'
    ];

    public function kategori()
    {
        return $this->belongsTo('App\Kategori');
    }
}
