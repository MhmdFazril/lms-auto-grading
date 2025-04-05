<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_attempts_id')->constrained('quiz_attempts')->onDelete('cascade');
            $table->foreignId('quiz_question_id')->constrained('quiz_questions');
            $table->integer('order');
            $table->foreignId('student_id')->constrained('users');
            $table->text('student_answer')->nullable();
            $table->boolean('markFlag')->default(false);
            $table->boolean('isCorrect')->nullable();
            $table->double('score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_answers');
    }
};
