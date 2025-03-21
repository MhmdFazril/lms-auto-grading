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
        Schema::create('mclasses', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->foreignId('teacher_id')->nullable();
            $table->text('deskripsi')->nullable();
            // $table->foreignId('major_id')->nullable()->constrained()->onDelete('set null');
            // $table->foreignId('academic_year_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mclasses');
    }
};
