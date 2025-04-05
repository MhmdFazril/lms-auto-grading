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
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_content_id')->constrained('course_contents')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->double('score')->nullable();
            $table->text('feedback')->nullable();
            $table->enum('status', ['attempt', 'finish'])->default('attempt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
