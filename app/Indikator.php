<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indikator extends Model
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

    public function detailindikator()
    {
        return $this->hasMany('App\DetailIndikator');
    }

    public function link()
    {
        return $this->hasOne('App\LinkIndikator');
    }

    public static function status($id)
    {
        if ($id == 1) {
            $status = "<span class='badge badge-warning'>Pengajuan</span>";
        } elseif ($id == 0) {
            $status = '<span class="badge badge-secondary">Draf</span>';
        } elseif ($id == 2) {
            $status = '<span class="badge badge-danger">Revisi</span>';
        } elseif ($id == 3) {
            $status = "<span class='badge badge-success'>Disetujui</span>";
        }

        return $status;
    }
}
