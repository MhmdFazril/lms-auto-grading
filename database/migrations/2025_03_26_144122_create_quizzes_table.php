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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('course_sections_id')->constrained('course_sections')->onDelete('cascade');
            $table->string('nama', 100);
            $table->text('deskripsi')->nullable();
            $table->dateTime('open_quiz');
            $table->dateTime('close_quiz');
            $table->integer('time_limit');
            $table->enum('satuan', ['menit', 'detik', 'jam'])->default('menit');
            $table->boolean('shuffle')->default(false);
            $table->integer('max_attempt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
