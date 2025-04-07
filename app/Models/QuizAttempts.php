<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempts extends Model
{
    /** @use HasFactory<\Database\Factories\QuizAttemptsFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['student'];

    public function studentAnswer()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
