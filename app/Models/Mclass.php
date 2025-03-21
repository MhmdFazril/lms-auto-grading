<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mclass extends Model
{
    /** @use HasFactory<\Database\Factories\MclassFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['teacher', 'sclass'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function sclass()
    {
        return $this->hasMany(Sclass::class);
    }
}
