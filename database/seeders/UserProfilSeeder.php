<?php

namespace Database\Seeders;

use App\Models\ProfilDosen;
use App\Models\ProfilMahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserProfilSeeder extends Seeder
{
    public function run(): void
    {
        $daftarMahasiswa = [
            ['nim' => '2510514014', 'name' => 'Ivan fransiscus', 'prodi' => 'S1 Sains Data', 'minat_bidang' => 'Data Engineer'],
            ['nim' => '2510514006', 'name' => 'Nindira', 'prodi' => 'S1 Sains Data', 'minat_bidang' => 'Project Management'],
            ['nim' => '2510514008', 'name' => 'Bram', 'prodi' => 'S1 Sains Data', 'minat_bidang' => 'Web Enggineer'],
            ['nim' => '2510514015', 'name' => 'Tina', 'prodi' => 'S1 Sains Data', 'minat_bidang' => 'Data Analyst'],
            ['nim' => '2510514017', 'name' => 'Arkan', 'prodi' => 'S1 Sains Data', 'minat_bidang' => 'AI Engineer'],
        ];

        foreach ($daftarMahasiswa as $mhs) {
            $user = User::firstOrCreate(
                ['email' => $mhs['nim'] . '@mahasiswa.upnvj.ac.id'],
                [
                    'name' => $mhs['name'],
                    'password' => 'password123',
                    'role' => 'mahasiswa',
                ]
            );

            ProfilMahasiswa::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nim' => $mhs['nim'],
                    'prodi' => $mhs['prodi'],
                    'angkatan' => 2025,
                    'minat_bidang' => $mhs['minat_bidang'],
                    'no_hp' => '08120000' . substr($mhs['nim'], -4),
                ]
            );
        }

        $daftarDosen = [
            ['nidn' => '0031089303', 'email' => 'muhammad.panji.muslim@upnvj.ac.id', 'name' => 'Muhammad Panji Muslim, S.Pd., M.Kom.', 'bidang' => 'Text Mining; Data Mining; Natural Language Processing; Service Oriented; Web'],
            ['nidn' => '0003119209', 'email' => 'novi.trisman@upnvj.ac.id', 'name' => 'Novi Trisman Hadi, S.Pd., M.Kom.', 'bidang' => 'Networking; Routing; Wireless Sensor Network; Internet of Things'],
        ];

        foreach ($daftarDosen as $dsn) {
            $user = User::firstOrCreate(
                ['email' => $dsn['email']],
                [
                    'name' => $dsn['name'],
                    'password' => 'dosen123',
                    'role' => 'dosen',
                ]
            );

            ProfilDosen::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nidn' => $dsn['nidn'],
                    'bidang_keahlian' => $dsn['bidang'],
                    'kuota_bimbingan' => 5,
                ]
            );
        }
    }
}