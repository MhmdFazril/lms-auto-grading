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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // common input
            $table->string('nama', 100);
            $table->string('tempat_tgl_lahir', 100);
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat')->nullable();
            $table->string('telp', 15)->nullable();
            $table->string('wa', 15)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->text('gambar')->nullable();
            $table->boolean('aktif')->default(true);
            $table->boolean('suspen')->default(false);
            $table->enum('role', ['admin', 'teacher', 'student'])->default('student');
            $table->text('catatan')->nullable();

            // teacher field
            $table->string('nip', 20)->unique()->nullable();
            $table->enum('pernikahan', ['yes', 'no', 'lainnya'])->default('no');
            $table->string('pendidikan', 20)->nullable();
            $table->string('prodi', 100)->nullable();
            $table->string('lembaga_pendidikan', 50)->nullable();
            $table->year('tahun_lulus')->nullable();

            // student field
            $table->string('nis', 20)->unique()->nullable();
            $table->string('nisn', 20)->unique()->nullable();
            $table->string('nama_wali', 100)->nullable();
            $table->string('nama_ayah', 100)->nullable();
            $table->string('nama_ibu', 100)->nullable();
            $table->string('pekerjaan_wali', 100)->nullable();
            $table->string('pekerjaan_ayah', 100)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->text('alamat_orwa')->nullable();
            $table->string('telp_orwa', 15)->nullable();
            $table->text('beasiswa')->nullable();
            $table->year('tahun_masuk')->nullable();

            // $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('set null');
            // $table->foreignId('major_id')->nullable()->constrained('majors')->onDelete('set null');

            $table->foreignId('school_id')->nullable();
            $table->foreignId('major_id')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
