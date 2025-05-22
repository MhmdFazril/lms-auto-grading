<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'MAS ADMIN ',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'kode_admin' => 'admin123'
        ]);
    }
}
