<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sclass extends Model
{
    /** @use HasFactory<\Database\Factories\SclassFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    // protected $with = ['student', 'major', 'mclass'];

    public function student()
    {
        return $this->belongsTo(User::class, 'students_id');
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function mclass()
    {
        return $this->belongsTo(Mclass::class);
    }

    public static function getNourut($mclass)
    {
        $cekNourut = self::where('mclass_id', $mclass)->orderBy('nourut', 'desc')->first();

        if ($cekNourut) {
            $nourut = $cekNourut->nourut;
        } else {
            $lastMclass = self::orderBy('mclass_id', 'desc')->first();
            $nourut = $lastMclass ? $lastMclass->mclass_id + 1 : 1;
            $nourut = str_pad($nourut, 3, '0', STR_PAD_LEFT);
        }
        return $nourut;
    }


    public static function getNoKey($mclass)
    {
        $cekNokey = self::where('mclass_id', $mclass)->orderBy('nokey', 'desc')->first();

        if (!$cekNokey) {
            $nourut = '001';
        } else {
            $nourut = str_pad($cekNokey->nokey + 1, 3, '0', STR_PAD_LEFT);
        }
        return $nourut;
    }
}
