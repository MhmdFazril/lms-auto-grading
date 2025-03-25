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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->unique();
            $table->text('deskripsi')->nullable();
            $table->foreignId('teacher_id', 2);
            $table->foreignId('academic_year_id', 2);
            $table->foreignId('major_id', 2);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('enrollment_key', 10)->nullable();
            $table->dateTime('start_enroll')->nullable();
            $table->dateTime('end_enroll')->nullable();
            $table->text('gambar', 2);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
