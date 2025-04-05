<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    protected $guarded = ['id'];
    protected $with = ['question'];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }
}
