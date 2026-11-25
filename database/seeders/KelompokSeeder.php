<?php

namespace Database\Seeders;

use App\Models\AnggotaKelompok;
use App\Models\Kelompok;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class KelompokSeeder extends Seeder
{
    public function run(): void
    {
        $skema = ['PKM-RE', 'PKM-K', 'PKM-KC', 'PKM-PI', 'PKM-GFK', 'PKM-KI'];

        $daftarTugas = [
            'Menyusun latar belakang dan rumusan masalah',
            'Menyusun tinjauan pustaka',
            'Menyusun metode pelaksanaan',
            'Menyusun rencana anggaran biaya',
            'Menyusun jadwal kegiatan',
        ];

        // Dosen pembimbing: pakai dosen dari UserProfilSeeder milik Ivan
        $idDosen = User::where('role', 'dosen')->orderBy('id')->pluck('id')->values();

        for ($k = 1; $k <= 40; $k++) {
            // Mahasiswa dummy 1-40 jadi ketua, 41-120 jadi anggota
            $ketua = $this->buatMahasiswa($k);

            $dospem = ($idDosen->isNotEmpty() && $k % 3 !== 0)
                ? $idDosen[($k - 1) % $idDosen->count()]
                : null;

            $kelompok = Kelompok::firstOrCreate(
                ['nama_kelompok' => "Kelompok PKM {$k}"],
                [
                    'skema_pkm' => $skema[($k - 1) % count($skema)],
                    'deskripsi_kebutuhan' => 'Mencari anggota dengan kemampuan analisis data dan penulisan proposal.',
                    'ketua_id' => $ketua->id,
                    'dosen_pembimbing_id' => $dospem,
                    'status_rekrutmen' => $k % 4 === 0 ? 'ditutup' : 'terbuka',
                ]
            );

            AnggotaKelompok::firstOrCreate(
                ['kelompok_id' => $kelompok->id, 'user_id' => $ketua->id],
                ['peran_anggota' => 'ketua', 'status_bergabung' => 'diterima']
            );

            foreach ([40 + ($k * 2 - 1), 40 + ($k * 2)] as $idx => $nomor) {
                $anggota = $this->buatMahasiswa($nomor);

                AnggotaKelompok::firstOrCreate(
                    ['kelompok_id' => $kelompok->id, 'user_id' => $anggota->id],
                    [
                        'peran_anggota' => 'anggota',
                        'status_bergabung' => ($idx === 1 && $k % 5 === 0) ? 'pending' : 'diterima',
                    ]
                );
            }

            foreach ($daftarTugas as $i => $judul) {
                Todo::firstOrCreate(
                    ['kelompok_id' => $kelompok->id, 'judul_tugas' => $judul],
                    [
                        'is_selesai' => $i < 2,
                        'tenggat_waktu' => now()->addDays(7 * ($i + 1))->toDateString(),
                    ]
                );
            }
        }
    }

    private function buatMahasiswa(int $n): User
    {
        return User::firstOrCreate(
            ['email' => "mhs{$n}@mahasiswa.upnvj.ac.id"],
            [
                'name' => "Mahasiswa {$n}",
                'password' => 'password123',
                'role' => 'mahasiswa',
            ]
        );
    }
}