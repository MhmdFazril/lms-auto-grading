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
        Schema::create('course_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('course_sections_id')->constrained('course_sections')->onDelete('cascade');
            $table->string('nama', 100);
            $table->text('deskripsi')->nullable();
            $table->enum('content_type', ['assignment', 'quiz', 'submission']);
            $table->text('content_url')->nullable();
            $table->dateTime('open_quiz')->nullable();
            $table->dateTime('close_quiz')->nullable();
            $table->integer('time_limit')->nullable();
            $table->enum('satuan', ['menit', 'detik', 'jam'])->default('menit')->nullable();
            $table->boolean('shuffle')->nullable();
            $table->integer('max_attempt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_contents');
    }
};
