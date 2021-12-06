<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lokal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tahun_id', 'unit_id', 'user_id', 'keterangan', 'status', 'catatan'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tahun()
    {
        return $this->belongsTo('App\Tahun');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function detaillokal()
    {
        return $this->hasMany('App\DetailLokal');
    }
}
