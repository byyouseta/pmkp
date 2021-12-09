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

    // public function imutlokal()
    // {
    //     return $this->hasMany('App\Lokal');
    // }
}
