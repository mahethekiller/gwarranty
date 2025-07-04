<?php

use App\Http\Controllers\Admin\UserManagement;
use App\Http\Controllers\Admin\WarrantyManagement;
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

// ALL ROLEs

Route::middleware('auth', 'role:admin|user|editor')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/user/profile/save', [ProfileController::class, 'update'])->name('user.profile.update');
});
// ALL ROLEs

// ADMIN ROLE

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');

    // user management
    Route::get('/admin/users', [UserManagement::class, 'index'])->name('admin.users.index');
    Route::get('/admin/user/{user}/edit', [UserManagement::class, 'edit'])->name('admin.users.edit');
    Route::post('/admin/user/update/{user}', [UserManagement::class, 'update'])->name('admin.users.update');
    Route::post('/admin/users/add', [UserManagement::class, 'store'])->name('admin.users.add');

});

// ADMIN ROLE

// EDITOR ROLE

Route::middleware(['auth', 'role:editor'])->group(function () {

});

// EDITOR ROLE

// USER ROLE

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

});

// USER ROLE

// ADMIN AND EDITOR ROLE

Route::middleware(['auth', 'role:admin|editor'])->group(function () {


     Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');


    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');

    // warranty management
    Route::get('/admin/warranty', [WarrantyManagement::class, 'index'])->name('admin.warranty.index');
    Route::get('/admin/warranty/edit/{warranty}', [WarrantyManagement::class, 'edit'])->name('admin.warranty.edit');
    Route::post('/admin/warranty/update/{warranty}', [WarrantyManagement::class, 'update'])->name('admin.warranty.update');
    // Route::post('/admin/warranty/add', [UserManagement::class, 'store'])->name('admin.warranty.add');




});

// ADMIN AND EDITOR ROLE

require __DIR__ . '/auth.php';
