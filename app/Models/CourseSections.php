<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSections extends Model
{
    /** @use HasFactory<\Database\Factories\CourseSectionsFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function contents()
    {
        return $this->hasMany(CourseContents::class);
    }

    // public function quizzes()
    // {
    //     return $this->hasMany(Quiz::class);
    // }
}
