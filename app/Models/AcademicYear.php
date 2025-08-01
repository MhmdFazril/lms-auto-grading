<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    /** @use HasFactory<\Database\Factories\AcademicYearFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    // protected $with = ['mclasses'];

    public function classes()
    {
        return $this->belongsTo(Mclass::class);
    }
}
