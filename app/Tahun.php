<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tahun extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'nama'
    ];

    public function imutlokal()
    {
        return $this->hasMany('App\Lokal');
    }
}
