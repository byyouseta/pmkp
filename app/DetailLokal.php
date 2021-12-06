<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailLokal extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'nama', 'target',
    ];

    public function lokal()
    {
        return $this->belongsTo('App\Lokal');
    }
}
