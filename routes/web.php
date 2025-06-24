<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WarrantyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// OTP Routes
Route::get('registerotp', [OtpController::class, 'showRegisterForm'])->name('registerotp');
Route::post('registerotp', [OtpController::class, 'sendOtpForRegistration']);
Route::get('verify-otp', [OtpController::class, 'showVerifyOtpForm'])->name('verify-otp');
Route::post('verify-otp', [OtpController::class, 'verifyOtp']);
Route::post('resend-otp', [OtpController::class, 'resendOtp'])->name('resend-otp');

Route::get('/loginotp', [OtpController::class, 'showLoginForm'])->name('loginotp');
Route::post('/login/send-otp', [OtpController::class, 'sendLoginOtp'])->name('login.send.otp');
Route::post('/login/verify-otp', [OtpController::class, 'verifyLoginOtp'])->name('login.verify.otp');

// OTP Routes

Route::get('/dashboard', function () {
    return view('dashboard.user');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'role:admin|user|editor')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'role:editor'])->group(function () {
    Route::get('/editor/dashboard', function () {
        return view('dashboard.editor');
    })->name('editor.dashboard');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('dashboard.user');
    })->name('user.dashboard');

    Route::get('/user/warranty/create', [WarrantyController::class, 'create'])->name('user.warranty.create');
    Route::post('/user/warranty/store', [WarrantyController::class, 'store'])->name('user.warranty.store');
    Route::get('/user/warranty/modify', [WarrantyController::class, 'index'])->name('user.warranty.modify');
    Route::get('/user/warranty/edit/{id}', [WarrantyController::class, 'edit'])->name('user.warranty.edit');
    Route::post('/user/warranty/update/{id}', [WarrantyController::class, 'update'])->name('user.warranty.update');
    Route::get('/user/warranty/certificate', [WarrantyController::class, 'create'])->name('user.warranty.certificate');


     Route::post('/user/profile/save', [ProfileController::class, 'update'])->name('user.profile.update');

});

require __DIR__ . '/auth.php';
