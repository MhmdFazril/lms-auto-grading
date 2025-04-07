<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseContents extends Model
{
    /** @use HasFactory<\Database\Factories\CourseContentsFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['quiz_question'];

    public function section()
    {
        return $this->belongsTo(CourseContents::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quiz_question()
    {
        return $this->hasMany(QuizQuestion::class, 'course_content_id');
    }

    public function studentAttempt()
    {
        return $this->hasMany(QuizAttempts::class, 'course_content_id');
    }
}
