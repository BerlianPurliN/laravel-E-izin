<?php

namespace Database\Seeders;

use App\Models\LeaveRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Admin / Tata Usaha ---
        User::create([
            'name' => 'Admin Tata Usaha',
            'email' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // --- Guru / Wali Kelas ---
        User::create([
            'name' => 'Budi Santoso, S.Pd.',
            'email' => 'guru@smpn6.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        $guru = User::create([
            'name' => 'Siti Aminah, S.Pd.',
            'email' => 'guru2@smpn6.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        // --- Siswa + data spesifik + contoh perizinan ---
        $siswaData = [
            ['name' => 'Ahmad Rizki', 'nisn' => '0071234567', 'kelas' => '7A'],
            ['name' => 'Dewi Lestari', 'nisn' => '0071234568', 'kelas' => '7A'],
            ['name' => 'Eko Prasetyo', 'nisn' => '0081234569', 'kelas' => '8B'],
            ['name' => 'Fitri Handayani', 'nisn' => '0091234570', 'kelas' => '9C'],
        ];

        foreach ($siswaData as $i => $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => 'siswa'.($i + 1).'@smpn6.sch.id',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'nisn' => $data['nisn'],
                'kelas' => $data['kelas'],
            ]);

            // Contoh riwayat perizinan
            LeaveRequest::create([
                'student_id' => $student->id,
                'jenis_izin' => 'Sakit',
                'tanggal_mulai' => now()->subDays(10)->toDateString(),
                'tanggal_selesai' => now()->subDays(9)->toDateString(),
                'alasan' => 'Demam dan flu, sudah periksa ke dokter.',
                'status' => 'Approved',
                'approved_by' => $guru->id,
                'catatan_guru' => 'Semoga lekas sembuh.',
            ]);

            LeaveRequest::create([
                'student_id' => $student->id,
                'jenis_izin' => 'Izin',
                'tanggal_mulai' => now()->addDays(2)->toDateString(),
                'tanggal_selesai' => now()->addDays(2)->toDateString(),
                'alasan' => 'Menghadiri acara keluarga (pernikahan saudara).',
                'status' => 'Pending',
            ]);
        }
    }
}
