<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\QuizQuestionFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'option' => 'array',  // Karena tipe data 'option' adalah json
    ];
}
