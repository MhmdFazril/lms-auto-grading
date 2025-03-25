<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Major;
use App\Models\Course;
use App\Models\Mclass;
use App\Models\School;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Sclass;
use App\Models\AcademicYear;
use App\Models\CourseSections;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(20)->create();

        // School::factory(2)->create();

        // AcademicYear::factory(2)->create();

        // Major::factory(2)->create();

        // Mclass::factory(2)->create();

        // Sclass::factory(2)->create();


        // Membuat 4 user dengan role 'student'
        User::create([
            'nama' => 'AHMAD TAUFIK',
            'tempat_tgl_lahir' => 'JAKARTA',
            'tgl_lahir' => '2005-04-15',
            'jenis_kelamin' => 'L',
            'alamat' => 'JL. MERDEKA NO. 10, JAKARTA',
            'telp' => '081234567890',
            'wa' => '081234567890',
            'email' => 'ahmad.taufik@mail.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
            'nis' => '1234567890',
            'nisn' => '9876543210',
            'nama_wali' => 'SITI AMINAH',
            'nama_ayah' => 'BUDI SANTOSO',
            'nama_ibu' => 'WINDA SARI',
            'pekerjaan_wali' => 'WIRASWASTA',
            'pekerjaan_ayah' => 'PEGAWAI NEGERI',
            'pekerjaan_ibu' => 'IBU RUMAH TANGGA',
            'alamat_orwa' => 'JL. WALI NO. 5, JAKARTA',
            'telp_orwa' => '081234567891',
            // 'beasiswa' => 'BEASISWA PRESTASI',
            'tahun_masuk' => '2021',
            'school_id' => 1,  // Asumsi sudah ada data di tabel sekolah
            'major_id' => 1,   // Asumsi sudah ada data di tabel major
        ]);

        User::create([
            'nama' => 'NADIA PUTRI',
            'tempat_tgl_lahir' => 'BANDUNG',
            'tgl_lahir' => '2004-07-20',
            'jenis_kelamin' => 'P',
            'alamat' => 'JL. SEJAHTERA NO. 12, BANDUNG',
            'telp' => '082345678901',
            'wa' => '082345678901',
            'email' => 'nadia.putri@mail.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
            'nis' => '1234567891',
            'nisn' => '9876543211',
            'nama_wali' => 'DINA RATNA',
            'nama_ayah' => 'JOHNSON PRATAMA',
            'nama_ibu' => 'ELSA DAMAYANTI',
            'pekerjaan_wali' => 'PEGAWAI SWASTA',
            'pekerjaan_ayah' => 'PENGUSAHA',
            'pekerjaan_ibu' => 'IBU RUMAH TANGGA',
            'alamat_orwa' => 'JL. WALI NO. 8, BANDUNG',
            'telp_orwa' => '082345678902',
            // 'beasiswa' => 'BEASISWA BIDIK MISI',
            'tahun_masuk' => '2022',
            'school_id' => 1,  // Asumsi sudah ada data di tabel sekolah
            'major_id' => 1,   // Asumsi sudah ada data di tabel major
        ]);

        User::create([
            'nama' => 'FIRMAN NUGROHO',
            'tempat_tgl_lahir' => 'YOGYAKARTA',
            'tgl_lahir' => '2005-03-10',
            'jenis_kelamin' => 'L',
            'alamat' => 'JL. MELATI NO. 15, YOGYAKARTA',
            'telp' => '083456789012',
            'wa' => '083456789012',
            'email' => 'firman.nugroho@mail.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
            'nis' => '1234567892',
            'nisn' => '9876543212',
            'nama_wali' => 'SAKTI PAMBUDI',
            'nama_ayah' => 'SUKIYANTO',
            'nama_ibu' => 'JANIATI',
            'pekerjaan_wali' => 'WIRASWASTA',
            'pekerjaan_ayah' => 'PEGAWAI SWASTA',
            'pekerjaan_ibu' => 'IBU RUMAH TANGGA',
            'alamat_orwa' => 'JL. WALI NO. 10, YOGYAKARTA',
            'telp_orwa' => '083456789013',
            // 'beasiswa' => 'BEASISWA PRESTASI AKADEMIK',
            'tahun_masuk' => '2021',
            'school_id' => 1,  // Asumsi sudah ada data di tabel sekolah
            'major_id' => 2,   // Asumsi sudah ada data di tabel major
        ]);

        User::create([
            'nama' => 'ELLA PRASTIWI',
            'tempat_tgl_lahir' => 'SEMARANG',
            'tgl_lahir' => '2006-01-05',
            'jenis_kelamin' => 'P',
            'alamat' => 'JL. KEMERDEKAAN NO. 20, SEMARANG',
            'telp' => '084567890123',
            'wa' => '084567890123',
            'email' => 'ella.prastiw@mail.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
            'nis' => '1234567893',
            'nisn' => '9876543213',
            'nama_wali' => 'YULIANA WULAN',
            'nama_ayah' => 'JOKO SANTOSO',
            'nama_ibu' => 'SRI WAHYUNI',
            'pekerjaan_wali' => 'PEGAWAI NEGERI',
            'pekerjaan_ayah' => 'PENGUSAHA',
            'pekerjaan_ibu' => 'IBU RUMAH TANGGA',
            'alamat_orwa' => 'JL. WALI NO. 30, SEMARANG',
            'telp_orwa' => '084567890124',
            // 'beasiswa' => 'BEASISWA PENUH',
            'tahun_masuk' => '2022',
            'school_id' => 1,  // Asumsi sudah ada data di tabel sekolah
            'major_id' => 2,   // Asumsi sudah ada data di tabel major
        ]);

        // Membuat 4 user dengan role 'teacher'
        User::create([
            'nama' => 'ALIF HARIYADI',
            'tempat_tgl_lahir' => 'BANDUNG',
            'tgl_lahir' => '1985-05-14',
            'jenis_kelamin' => 'L',
            'alamat' => 'JL. RAYA PENDIDIKAN NO. 7, BANDUNG',
            'telp' => '085678901234',
            'wa' => '085678901234',
            'email' => 'alif.hariyadi@mail.com',
            'password' => bcrypt('password123'),
            'role' => 'teacher',
            'nip' => 'NIP123456789',
            'pernikahan' => 'yes',
            'pendidikan' => 'Sarjana',
            'prodi' => 'PENDIDIKAN MATEMATIKA',
            'lembaga_pendidikan' => 'UNIVERSITAS BANDUNG',
            'tahun_lulus' => '2008',
            'school_id' => 1,  // Asumsi sudah ada data di tabel sekolah
            'major_id' => 1,   // Asumsi sudah ada data di tabel major
        ]);

        User::create([
            'nama' => 'RINA SARI',
            'tempat_tgl_lahir' => 'SURABAYA',
            'tgl_lahir' => '1984-11-22',
            'jenis_kelamin' => 'P',
            'alamat' => 'JL. PENDIDIKAN NO. 12, SURABAYA',
            'telp' => '085789012345',
            'wa' => '085789012345',
            'email' => 'rina.sari@mail.com',
            'password' => bcrypt('password123'),
            'role' => 'teacher',
            'nip' => 'NIP987654321',
            'pernikahan' => 'no',
            'pendidikan' => 'Sarjana',
            'prodi' => 'PENDIDIKAN BAHASA INGGRIS',
            'lembaga_pendidikan' => 'UNIVERSITAS SURABAYA',
            'tahun_lulus' => '2007',
            'school_id' => 1,  // Asumsi sudah ada data di tabel sekolah
            'major_id' => 1,   // Asumsi sudah ada data di tabel major
        ]);

        User::create([
            'nama' => 'MARTINUS WAHYUDI',
            'tempat_tgl_lahir' => 'MEDAN',
            'tgl_lahir' => '1980-09-11',
            'jenis_kelamin' => 'L',
            'alamat' => 'JL. KEMERDEKAAN NO. 3, MEDAN',
            'telp' => '087678901234',
            'wa' => '087678901234',
            'email' => 'martinus.wahyudi@mail.com',
            'password' => bcrypt('password123'),
            'role' => 'teacher',
            'nip' => 'NIP567891234',
            'pernikahan' => 'yes',
            'pendidikan' => 'Sarjana',
            'prodi' => 'PENDIDIKAN FISIKA',
            'lembaga_pendidikan' => 'UNIVERSITAS MEDAN',
            'tahun_lulus' => '2004',
            'school_id' => 1,  // Asumsi sudah ada data di tabel sekolah
            'major_id' => 1,   // Asumsi sudah ada data di tabel major
        ]);

        User::create([
            'nama' => 'LINA SUKMAWATI',
            'tempat_tgl_lahir' => 'JAKARTA',
            'tgl_lahir' => '1978-02-25',
            'jenis_kelamin' => 'P',
            'alamat' => 'JL. RAYA NO. 6, JAKARTA',
            'telp' => '085123456789',
            'wa' => '085123456789',
            'email' => 'lina.sukmawati@mail.com',
            'password' => bcrypt('password123'),
            'role' => 'teacher',
            'nip' => 'NIP246801357',
            'pernikahan' => 'no',
            'pendidikan' => 'Sarjana',
            'prodi' => 'PENDIDIKAN BAHASA INDONESIA',
            'lembaga_pendidikan' => 'UNIVERSITAS JAKARTA',
            'tahun_lulus' => '2003',
            'school_id' => 1,  // Asumsi sudah ada data di tabel sekolah
            'major_id' => 1,   // Asumsi sudah ada data di tabel major
        ]);

        School::create([
            'nama' => 'SMK GRAFIKA YAYASAN LEKTUR',
            'alamat' => 'JL PASAR JUMAT',
            'email' => 'grafika@mail.com',
        ]);

        AcademicYear::create([
            'tahun1' => '2024',
            'tahun2' => '2025',
        ]);

        Major::create([
            'nama' => 'TEKNIK KOMPUTER JARINGAN'
        ]);

        Major::create([
            'nama' => 'MULTIMEDIA'
        ]);

        Mclass::create([
            'nama' => 'X-A',
            'teacher_id' => '5',
        ]);

        Mclass::create([
            'nama' => 'X-B',
            'teacher_id' => '6',
        ]);

        Sclass::create([
            'nourut' => '001',
            'nokey' => '001',
            'students_id' => '1',
            'teacher_id' => '1',
            'mclass_id' => '1',
            'major_id' => '1',
            'academic_year_id' => '1',
        ]);

        Sclass::create([
            'nourut' => '001',
            'nokey' => '002',
            'students_id' => '2',
            'teacher_id' => '1',
            'mclass_id' => '1',
            'major_id' => '1',
            'academic_year_id' => '1',
        ]);

        Sclass::create([
            'nourut' => '002',
            'nokey' => '001',
            'students_id' => '3',
            'teacher_id' => '2',
            'mclass_id' => '2',
            'major_id' => '2',
            'academic_year_id' => '1',
        ]);

        Sclass::create([
            'nourut' => '002',
            'nokey' => '002',
            'students_id' => '4',
            'teacher_id' => '2',
            'mclass_id' => '2',
            'major_id' => '2',
            'academic_year_id' => '1',
        ]);

        Course::create([
            'nama' => 'PENJAS ORKES',
            'teacher_id' => '7',
            'academic_year_id' => '1',
            'major_id' => '1',
            'start_date' => '2025-03-12 20:00:00',
            'end_date' => '2026-03-12 20:00:00',
            'gambar' => 'asset/background_course' . rand(2, 7) . '.jpg'
        ]);

        Course::create([
            'nama' => 'AGAMA ISLAM',
            'teacher_id' => '6',
            'academic_year_id' => '1',
            'major_id' => '2',
            'start_date' => '2025-03-12 20:00:00',
            'end_date' => '2026-03-12 20:00:00',
            'gambar' => 'asset/background_course' . rand(2, 7) . '.jpg'
        ]);

        CourseSections::create([
            'course_id' => '1',
            'nama' => 'section 1',
        ]);

        CourseSections::create([
            'course_id' => '1',
            'nama' => 'section 2',
        ]);

        CourseSections::create([
            'course_id' => '1',
            'nama' => 'section 3',
        ]);

        CourseSections::create([
            'course_id' => '2',
            'nama' => 'section 1',
        ]);

        CourseSections::create([
            'course_id' => '2',
            'nama' => 'section 2',
        ]);

        CourseSections::create([
            'course_id' => '2',
            'nama' => 'section 3',
        ]);
    }
}
