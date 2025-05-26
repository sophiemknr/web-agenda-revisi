<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AgendaController;
use App\Models\Agenda;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SuperadminMiddleware;

Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
Route::get('/agenda/{status}', [AgendaController::class, 'showByStatus'])->name('agenda.status');
Route::get('/api/agendas/{date}', [AgendaController::class, 'getAgendasByDate'])->name('agenda.byDate');
Route::get('/api/agenda-dates', [AgendaController::class, 'getAgendaDatesForMonth'])->name('agenda.dates');
Route::get('/api/national-holidays', [AgendaController::class, 'getNationalHolidays'])->name('national.holidays');
Route::get('/api/agendas/{date}', [AgendaController::class, 'getAgendasByDate']);
Route::delete('/agenda/{id}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');

Route::get('add-to-log', 'HomeController@myTestAddToLog');

Route::get('logActivity', 'HomeController@logActivity');

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/dashboard', [AgendaController::class, 'dashboard'])->middleware('auth')->name('dashboard');


Route::middleware(['auth'])->group(function () {

    Route::get('/new', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/new', function () {
        return view('new');
    });
    Route::get('/draft', function () {
        return view('draft');
    });
    Route::get('/tentative', function () {
        return view('tentative');
    });
    Route::get('/confirm', function () {
        return view('confirm');
    });
    Route::get('/cancel', function () {
        return view('cancel');
    });
    Route::get('/laporan', function () {
        return view('laporan');
    });
    Route::get('/editprofile', function () {
        return view('editprofile');
    });
});

Route::middleware(['auth', SuperadminMiddleware::class])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/user', [UserController::class, 'store'])->name('storeUser');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
});

Route::get('/draft', [AgendaController::class, 'draft']);
Route::get('/tentative', [AgendaController::class, 'tentative']);
Route::get('/confirm', [AgendaController::class, 'confirm']);
Route::get('/cancel', [AgendaController::class, 'cancel']);
Route::get('/print', [AgendaController::class, 'print']);

Route::get('/reschedule/{id}', [AgendaController::class, 'showRescheduleForm'])->name('agenda.reschedule'); // GET route for reschedule form
Route::post('/reschedule/{id}', [AgendaController::class, 'reschedule'])->name('agenda.reschedule.update'); // POST route for reschedule update

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
