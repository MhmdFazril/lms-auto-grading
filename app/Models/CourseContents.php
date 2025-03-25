<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseContents extends Model
{
    /** @use HasFactory<\Database\Factories\CourseContentsFactory> */
    use HasFactory;

    protected $guarded = ['id'];
}
