<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // return [
        //     'nip' => fake()->unique()->numerify('###########'), // NIP unik
        //     'nisn' => fake()->unique()->numerify('##########'), // NISN unik
        //     'nama' => fake()->name(),
        //     'wali' => fake()->name(),
        //     'tempat_tgl_lahir' => fake()->city(),
        //     'tgl_lahir' => fake()->date(),
        //     'alamat' => fake()->address(),
        //     'alamat_wali' => fake()->address(),
        //     'telp' => fake()->optional()->numerify('08##########'),
        //     'wa' => fake()->optional()->numerify('08##########'),
        //     'telp_wali' => fake()->numerify('08##########'),
        //     'email' => fake()->unique()->safeEmail(),
        //     'email_verified_at' => now(),
        //     'password' => bcrypt('password'), // Default password
        //     'id_school' => rand(1, 10), // Anggap ada 10 sekolah di tabel schools
        //     'role' => fake()->randomElement(['admin', 'teacher', 'student']),
        //     'remember_token' => Str::random(10),
        // ];

        return [
            'nip' => $this->faker->unique()->numerify('###########'), // NIP unik (hanya untuk teacher/admin)
            'nis' => $this->faker->unique()->numerify('##########'), // NIS unik (hanya untuk student)
            'nisn' => $this->faker->unique()->numerify('##########'), // NISN unik
            'nama' => $this->faker->name(),
            'nama_wali' => $this->faker->name(),
            'nama_ayah' => $this->faker->name(),
            'nama_ibu' => $this->faker->name(),
            'pekerjaan_wali' => $this->faker->jobTitle(),
            'pekerjaan_ayah' => $this->faker->jobTitle(),
            'pekerjaan_ibu' => $this->faker->jobTitle(),
            'tempat_tgl_lahir' => $this->faker->city(),
            'tgl_lahir' => $this->faker->date(),
            'alamat' => $this->faker->address(),
            'alamat_orwa' => $this->faker->optional()->address(),
            'telp' => $this->faker->optional()->numerify('08##########'),
            'wa' => $this->faker->optional()->numerify('08##########'),
            'telp_orwa' => $this->faker->numerify('08##########'),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // Default password
            // 'id_school' => rand(1, 10), // Anggap ada 10 sekolah di tabel schools
            // 'id_major' => rand(1, 5), // Anggap ada 5 jurusan
            // 'id_class' => rand(1, 15), // Anggap ada 15 kelas
            'tahun_masuk' => $this->faker->year(),
            'tahun_lulus' => $this->faker->year(),
            'pernikahan' => $this->faker->randomElement(['yes', 'no', 'lainnya']),
            'pendidikan' => $this->faker->text(20),
            'prodi' => $this->faker->text(20),
            'lembaga_pendidikan' => $this->faker->name(),
            'beasiswa' => $this->faker->name(),
            'gambar' => null,
            'aktif' => $this->faker->boolean(90), // 90% aktif
            'suspen' => $this->faker->boolean(5), // 5% suspend
            'role' => $this->faker->randomElement(['teacher', 'student']),
            'catatan' => $this->faker->optional()->text(100),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
