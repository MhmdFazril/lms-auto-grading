<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    /** @use HasFactory<\Database\Factories\MajorFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    // protected $with = ['mclasses'];

    public function classes()
    {
        return $this->hasMany(Mclass::class);
    }
}
