<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\HasilAkhirController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest routes - with sanitization for form submissions
Route::middleware(['guest', 'sanitize', 'csp'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    // Authentication routes (tanpa throttle)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Registration routes (tanpa throttle)
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    // Email verification routes
    Route::get('/verify-sent', [RegisterController::class, 'showVerificationSent'])->name('verify.sent');
    Route::get('/verify-account/{token}', [VerificationController::class, 'verifyAccount'])->name('verify.account');

    // Resend verification routes (tanpa throttle)
    Route::get('/resend-verification', [VerificationController::class, 'showResendForm'])->name('verification.resend');
    Route::post('/resend-verification', [VerificationController::class, 'resendVerification'])->name('verification.resend.post');

    // Password reset routes (tanpa throttle)
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Authenticated routes - with sanitization for all form submissions
Route::middleware(['auth.user', 'sanitize', 'csp'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::resource('kriteria', KriteriaController::class);
        Route::resource('subkriteria', SubKriteriaController::class);
        Route::resource('alternatif', AlternatifController::class);

        Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/create', [PenilaianController::class, 'create'])->name('penilaian.create');
        Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
        Route::get('/penilaian/edit', [PenilaianController::class, 'edit'])->name('penilaian.edit');
        Route::put('/penilaian', [PenilaianController::class, 'update'])->name('penilaian.update');
        Route::delete('/penilaian/{id}', [PenilaianController::class, 'destroy'])->name('penilaian.destroy');

        Route::get('/perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');

        Route::resource('user', UserController::class);
    });

    // Common authenticated routes
    Route::get('/hasilakhir', [HasilAkhirController::class, 'index'])->name('hasilakhir.index');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
