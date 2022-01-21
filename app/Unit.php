<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'nama', 'keterangan'
    ];

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function indikator()
    {
        return $this->hasMany('App\Indikator');
    }
}
