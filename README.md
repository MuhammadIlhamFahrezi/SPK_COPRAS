<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Copras

Sistem Pendukung Keputusan (SPK) merupakan suatu sistem informasi spesifik yang ditujukan untuk membantu manajemen dalam mengambil keputusan yang berkaitan dengan persoalan yang bersifat semi terstruktur.

Metode Complex Proportional Assessment (COPRAS) mengasumsikan ketergantungan langsung dan proporsional dari tingkat signifikansi dan utilitas dari alternatif yang ada dengan adanya kriteria yang saling bertentangan. Ini memperhitungkan kinerja alternatif sehubungan dengan kriteria yang berbeda dan juga bobot kriteria yang sesuai. Metode ini memilih keputusan terbaik mengingat solusi ideal dan ideal-terburuk.

## Project Structure

```
app/
│
├── Models/
│   ├── User.php
│   ├── Kriteria.php
│   ├── SubKriteria.php
│   ├── Alternatif.php
│   └── NilaiAlternatif.php
│
├── Services/
│   └── CoprasService.php
│
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── KriteriaController.php
│   │   ├── SubKriteriaController.php
│   │   ├── AlternatifController.php
│   │   ├── PenilaianController.php
│   │   ├── PerhitunganController.php
│   │   ├── HasilAkhirController.php
│   │   ├── UserController.php
│   │   └── ProfileController.php
│   │
│   ├── Middleware/
│   │   ├── IsAdmin.php
│   │   └── IsUser.php
│   │
database/
├── migrations/
│   ├── 2024_XX_create_users_table.php
│   ├── 2024_XX_create_kriteria_table.php
│   ├── 2024_XX_create_sub_kriteria_table.php
│   ├── 2024_XX_create_alternatif_table.php
│   ├── 2024_XX_create_nilai_alternatif_table.php
│
├── seeders/
│   ├── DatabaseSeeder.php
│   ├── KriteriaSeeder.php
│   ├── SubKriteriaSeeder.php
│   ├── AlternatifSeeder.php
│   ├── NilaiAlternatifSeeder.php
│   └── UserSeeder.php
│
resources/
├── views/
│   ├── auth/
│   │   └── login.blade.php
│   ├── dashboard/
│   │   ├── index.blade.php
│   ├── layouts/
│   │   └── app.blade.php
│   ├── kriteria/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── subkriteria/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── alternatif/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── penilaian/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── perhitungan/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── hasilakhir/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── user/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   └── profile/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
│
routes/
└── web.php
```

## Database Structure

```sql
CREATE TABLE kriteria (
    id_kriteria INT AUTO_INCREMENT PRIMARY KEY,
    kode_kriteria VARCHAR(10),
    nama_kriteria VARCHAR(100) NOT NULL,
    jenis VARCHAR(10) CHECK (jenis IN ('Benefit', 'Cost')),
    bobot DECIMAL(5,2) -- persen, misal: 20.00
);

CREATE TABLE sub_kriteria (
    id_subkriteria INT AUTO_INCREMENT PRIMARY KEY,
    id_kriteria INT,
    nama_subkriteria VARCHAR(100),
    Nilai INT,
    FOREIGN KEY (id_kriteria) REFERENCES kriteria(id_kriteria) ON DELETE CASCADE
);

CREATE TABLE alternatif (
    id_alternatif INT AUTO_INCREMENT PRIMARY KEY,
    kode_alternatif VARCHAR(10) UNIQUE,
    nama_alternatif VARCHAR(100)
);

CREATE TABLE nilai_alternatif (
    id_nilai INT AUTO_INCREMENT PRIMARY KEY,
    id_alternatif INT,
    id_kriteria INT,
    nilai_subkriteria VARCHAR(100),
    bobot_subkriteria INT,
    FOREIGN KEY (id_alternatif) REFERENCES alternatif(id_alternatif) ON DELETE CASCADE,
    FOREIGN KEY (id_kriteria) REFERENCES kriteria(id_kriteria) ON DELETE CASCADE
);

CREATE TABLE user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Installation Guide

1. Place the project in htdocs directory

2. Run the following commands:

    ```
    php artisan migrate
    php artisan db:seed
    ```

3. If you need to update the data:

    ```
    php artisan migrate:refresh
    php artisan db:seed
    ```

4. If step 3 fails, manually drop the database and run step 2 again

5. Start the application:
    ```
    php artisan serve
    ```
6. Access the application by visiting:
    ```
    http://127.0.0.1:8000
    ```

## User Login Information

Login credentials can be found in `Database/Seeder/UserSeeder.php`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
