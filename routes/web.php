<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

// Rute Publik (Login)
Route::get('/', function () {
    return view('login');
})->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Rute yang Membutuhkan Autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AgendaController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    // Agenda
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/new', [AgendaController::class, 'create'])->name('new');
    Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
    Route::delete('/agenda/{id}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
    Route::get('/reschedule/{id}', [AgendaController::class, 'showRescheduleForm'])->name('agenda.reschedule');
    Route::post('/reschedule/{id}', [AgendaController::class, 'reschedule'])->name('agenda.reschedule.update');

    // Laporan
    Route::get('/laporan', [AgendaController::class, 'laporan'])->name('laporan');

    // Halaman Statis
    Route::view('/editprofile', 'editprofile')->name('editprofile');
    Route::view('/settings', 'settings')->name('settings');

    // API
    Route::get('/api/agendas/{date}', [AgendaController::class, 'getAgendasByDate']);
    Route::get('/api/agenda-dates', [AgendaController::class, 'getAgendaDatesForMonth']);
    Route::get('/api/national-holidays', [AgendaController::class, 'getNationalHolidays']);

    // Manajemen User (Khusus Superadmin/Admin)
    Route::middleware(['superadmin'])->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    });
});
