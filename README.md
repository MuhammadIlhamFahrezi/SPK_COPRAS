<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Copras

Metode COmplex PRoportional Assessment COPRAS diperkenalkan oleh Zavadskas pada tahun 1994 (Zavadskas et al., 1994) biasanya diterapkan dalam keadaan di mana pembuat keputusan dipaksa untuk memilih di antara banyak alternatif sambil mempertimbangkan serangkaian kriteria yang biasanya saling bertentangan

Gagasan COPRAS dipelopori oleh Zavadskas et al. untuk memecahkan masalah MCDA secara efektif. Hasil utama dari pendekatan COPRAS adalah sebagai berikut: (1) penerapannya sederhana; (2) mempertimbangkan rasio terhadap opsi dan solusi ideal, pada saat yang sama; dan (3) mengembalikan hasilnya dalam waktu singkat. (Mardani et al., 2023)

Metode COmplex PRoportional Assessment (COPRAS) menggunakan peringkat bertahap dan mengevaluasi prosedur alternatif dalam hal signifikansi dan tingkat utilitas. Metode COPRAS memiliki kemampuan untuk memperhitungkan kriteria positif (menguntungkan) dan negatif (tidak menguntungkan), yang dapat dinilai secara terpisah dalam proses evaluasi (Makhesana, 2015). Metode ini lebih unggul dari metode lain karena metode ini dapat digunakan untuk menghitung tingkat utilitas alternatif yang menunjukkan sejauh mana satu alternatif lebih baik atau lebih buruk dari pada alternatif lain yang diambil untuk perbandingan. ( Aan et al, 2017)

### Decision Support System with COPRAS Method

This application is an advanced Decision Support System (DSS) designed to facilitate complex decision-making processes in semi-structured environments. It leverages the powerful **Complex Proportional Assessment (COPRAS)** methodology to provide robust, data-driven recommendations.

### What makes COPRAS powerful?

The COPRAS method excels at handling multi-criteria decision problems where both beneficial criteria (higher values are better) and cost criteria (lower values are better) must be considered simultaneously. This sophisticated approach:

-   Evaluates alternatives against multiple weighted criteria
-   Handles contradictory criteria effectively
-   Considers both maximizing and minimizing parameters
-   Determines proportional direct and transitive dependencies
-   Calculates utility degrees of alternatives with mathematical precision
-   Produces a clear ranking of options based on comprehensive analysis

COPRAS delivers superior results compared to simpler decision methods by balancing positive and negative ideal solutions, making it ideal for complex organizational decision-making processes that require systematic evaluation of multiple factors.

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
│   │   ├── IsUser.php
│   │   └── SanitizeInput.php
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
tests/
├── Feature/
│   └── SanitizeInputTest.php
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

1. Go to the htdocs folder
   Open C:\xampp\htdocs using File Explorer or a terminal.

2. Open Command Prompt (CMD) in the htdocs folder, then clone the Laravel repository:

    ```
    git clone https://github.com/MuhammadIlhamFahrezi/SPK_COPRAS.git
    ```

3. Navigate to the Laravel project directory:

    ```
    cd SPK_COPRAS
    ```

4. Install Laravel dependencies using Composer:

    ```
    composer install
    ```

5. Copy .env.example to .env:

    ```
    cp .env.example .env
    ```

6. Edit your .env file to match your database configuration:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=Copras_V1
    DB_USERNAME=root
    DB_PASSWORD=

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=yuruminayumi@gmail.com
    MAIL_PASSWORD=xqnzetaaKzecblyy
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=copras.app@gmail.com
    MAIL_FROM_NAME="Copras"
    ```

7. Generate the application key:

    ```
    php artisan key:generate
    ```

8. Run the following commands:

    ```
    php artisan migrate
    php artisan db:seed
    ```

9. If you need to update the data:

    ```
    php artisan migrate:refresh
    php artisan db:seed
    ```

10. If step 3 fails, manually drop the database and run step 2 again

11. To seed a specific seeder class only (e.g., UserSeeder or AlternatifSeeder):
    ```
    php artisan db:seed --class=SeederClassName
    ```
    Example:
    ```
    php artisan db:seed --class=UserSeeder
    php artisan db:seed --class=AlternatifSeeder
    ```
12. Start the application:
    ```
    php artisan serve
    ```
13. Access the application by visiting:
    ```
    http://127.0.0.1:8000
    ```
14. Test Santizie XSS, SQL:
    ```
    php artisan test --filter SanitizeInputTest
    ```

## User Login Information

Login credentials can be found in `Database/Seeder/UserSeeder.php`

## TEAM

1. M. Ilham Fahrezi
2. Anjuan Kaisar
3. Rayner Aditya

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
