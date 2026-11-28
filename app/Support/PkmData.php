<?php

namespace App\Support;

class PkmData
{
    // Skema PKM 2026. Cocokkan dengan Panduan PKM 2026 dari kampus/Belmawa.
    public const SKEMA = [
        'PKM-RE' => 'Riset Eksakta',
        'PKM-RSH' => 'Riset Sosial Humaniora',
        'PKM-PM' => 'Pengabdian kepada Masyarakat',
        'PKM-PI' => 'Penerapan IPTEK',
        'PKM-K' => 'Kewirausahaan',
        'PKM-KC' => 'Karsa Cipta',
        'PKM-KI' => 'Karya Inovatif',
        'PKM-VGK' => 'Video Gagasan Konstruktif',
        'PKM-AI' => 'Artikel Ilmiah',
        'PKM-GFT' => 'Gagasan Futuristik Tertulis',
    ];

    public const TIPE_POSTINGAN = [
        'cari_kelompok' => 'Butuh kelompok',
        'cari_anggota' => 'Kekurangan anggota',
        'lainnya' => 'Lainnya',
    ];

    // Checklist umum semua PKM (acuan 2026).
    // Tidak semua aturan sama di tiap skema, jadi angka yang berbeda ditulis "sesuai buku skema".
    // Urutan array = urutan tampil. Kunci = kategori.
    public const CHECKLIST = [
        'Tim dan administrasi' => [
            '3-5 mahasiswa aktif D3/D4/S1 dari satu kampus, terdaftar di PDDikti (1 ketua, 2-4 anggota)',
            'Tidak ada anggota yang sudah bergelar D3/D4/S1 atau sedang profesi/koas',
            'Nama sesuai PDDikti, tim disarankan dari minimal 2 angkatan',
            'Tiap mahasiswa hanya ikut 1 PKM, sebagai ketua atau anggota',
            'Tidak mengusulkan PPK Ormawa atau P2MW di tahun yang sama',
            'Dosen pendamping punya NUPTK dan mendampingi maksimal 10 tim',
            'Kesesuaian topik dengan bidang ilmu tim sudah sesuai buku skema',
            'Seleksi internal dan pendaftaran lewat operator kampus sudah beres',
            'Isian di Simbelmawa lengkap dan benar',
        ],
        'Format' => [
            'Judul maksimal 20 kata dan memenuhi aturan penulisan skema',
            'A4, satu kolom, margin kiri 4 cm; kanan, atas, bawah 3 cm',
            'Times New Roman 12 dan spasi 1,15 untuk teks utama, kecuali bagian yang diatur khusus',
            'Paragraf rata kiri-kanan',
            'Tidak ada halaman sampul dan pengesahan di PDF',
            'Jumlah halaman sesuai buku skema',
            'Posisi dan awal nomor halaman sesuai buku skema',
        ],
        'Isi dan daftar pustaka' => [
            'Urutan bagian atau bab sama persis dengan buku skema',
            'Daftar isi dan abstrak/ringkasan disertakan atau ditiadakan sesuai buku skema',
            'Daftar pustaka bergaya Harvard dan urut alfabet',
            'Sitasi dan daftar pustaka cocok dua arah',
            'Semua nama penulis ditulis di daftar pustaka, tanpa "et al." atau "dkk"',
            'Jumlah dan usia rujukan memenuhi ketentuan skema, jika ada',
        ],
        'Anggaran dan jadwal (jika diminta skema)' => [
            'Besar dana, sumber dana, dan batas tiap pos sesuai buku skema',
            'Tidak ada biaya yang dilarang',
            'Hitungan anggaran benar',
            'Durasi dan format jadwal sesuai buku skema',
        ],
        'Lampiran' => [
            'Semua lampiran wajib ada dan urutannya benar',
            'Biodata dan surat pernyataan lengkap',
            'Tanda tangan basah asli, bukan potong-tempel',
            'Meterai ada di dokumen yang mewajibkannya',
            'Dokumen khusus skema ada, misalnya surat mitra',
            'Uji similaritas dilampirkan dan memenuhi batas, jika diwajibkan',
            'Penggunaan AI sesuai ketentuan Belmawa',
        ],
        'Pemeriksaan akhir' => [
            'Berkas berbentuk PDF dengan nama sesuai format skema',
            'Tata letak rapi dan hasil pindaian terbaca',
            'Berkas sudah terunggah di Simbelmawa',
            'Validasi dosen pendamping dan pimpinan kampus bidang kemahasiswaan selesai sebelum tenggat',
        ],
    ];

    public static function kodeSkema(): array
    {
        return array_keys(self::SKEMA);
    }

    public static function kodeTipe(): array
    {
        return array_keys(self::TIPE_POSTINGAN);
    }
}
