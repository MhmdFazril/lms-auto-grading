<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempts extends Model
{
    /** @use HasFactory<\Database\Factories\QuizAttemptsFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function studentAnswer()
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
