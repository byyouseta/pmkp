<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RangeIku extends Model
{
    protected $fillable = [
        'awal', 'akhir', 'nilai'
    ];

    public static function nilaiiku($nilai)
    {
        $data = RangeIku::all();
        $nilaiiku = 0;

        foreach ($data as $range) {
            if (($nilai > $range->awal) and ($nilai < $range->akhir)) {
                $nilaiiku = $range->nilai;
            }
        }

        return $nilaiiku;
    }
}
