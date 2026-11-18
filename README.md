#PKM Center

Project Akhir Mata Kuliah Pemrograman Web — S1 Sains Data FIK UPN "Veteran" Jakarta.
= aplikasi web based Laravel untuk memberikan tempat untuk pembentukan tim PKM, pengajuan judul, dosen pembimbing beserta jadwal hingga history revision.

## Kebutuhan Sistem
- PHP 8.2 atau lebih baru
- Composer
- MySQL (XAMPP / Laragon)

## Cara Menjalankan dari Nol
1. git clone https://github.com/ivanfransiscuss/Project-PemrogramanWeb.git
2. cd Project-PemrogramanWeb
3. composer install
4. copy .env.example .env (macos: cp .env.example .env)
5. buat basis data kosong baru bernama project_web di phpMyAdmin
6. Sesuaikan database pada file '.env'
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_web
DB_USERNAME=root
DB_PASSWORD=
7. php artisan key:generate
8. php artisan migrate --seed
9. `php artisan serve` lalu buka http://127.0.0.1:8000

## Pembagian Tugas Kelompok

| Nama | NIM | Bagian yang Dikerjakan |
| :--- | :--- | :--- |
| Ivan Fransiscus | 2510514014 | Inisialisasi kerangka proyek, tata letak utama, pengelolaan repositori dan pull Request, serta modul Direktori Dosen dan Pengajuan Dospem |
| Arkan | 2510514017 | Modul login, Pengisian Biodata Awal, Edit Profil Pengguna, dan FAQ |
| Tinna | 2510514015 | Modul PKM Match (Pencarian dan Pembentukan Kelompok) serta To-Do List PKM |
| Nindira | 2510514006 | Modul Manajemen Jadwal Kosong Dosen dan Pemesanan (*Booking*) Bimbingan |
| Bram | 2510514008 | Modul Dashboard Utama, Repositori Proposal, dan Catatan Bimbingan (*Logbook*) |


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
