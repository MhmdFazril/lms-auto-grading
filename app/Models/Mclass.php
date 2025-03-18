<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mclass extends Model
{
    /** @use HasFactory<\Database\Factories\MclassFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    // protected $with = ['majors', 'academic_years'];

    // public function major()
    // {
    //     return $this->belongsTo(Major::class);
    // }

    // public function academic_year()
    // {
    //     return $this->belongsTo(AcademicYear::class);
    // }
}
