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
        Schema::create('sclasses', function (Blueprint $table) {
            $table->id();
            $table->double('nokey');
            $table->foreignId('students_id');
            $table->foreignId('teacher_id');
            $table->foreignId('mclass_id')->nullable();
            $table->foreignId('major_id')->nullable();
            $table->foreignId('academic_year_id')->nullable();
            $table->enum('status', ['aktif', 'naik_kelas', 'tinggal_kelas', 'lulus'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sclasses');
    }
};
