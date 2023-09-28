<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SetsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('throttle:60,1')->group(function () {
    Route::get('/', static function () {
        return view('welcome');
    })->name('home');
    Route::get('/signup', [AuthController::class, 'register'])->name('register');
    Route::post('/signup', [AuthController::class, 'registerPost'])->name('register.post');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPasswordPost'])
        ->name('forgot.password.post');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password', [AuthController::class, 'resetPasswordPost'])->name('reset.password.post');
Route::get('/confirm-email/{token}', [AuthController::class, 'confirmEmail'])->name('confirm.email');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('/sets')->group(function () {
        Route::get('/', [SetsController::class, 'index'])->name('sets.index');
        Route::get('create', [SetsController::class, 'create'])->name('sets.create');
        Route::post('create', [SetsController::class, 'store'])->name('sets.store');
        Route::get('{number}', [SetsController::class, 'show'])->where('number', '^\d{6}$')
            ->name('sets.show');
        Route::get('/destroy/{number}', [SetsController::class, 'destroy'])->name('sets.destroy');
    });
});

Route::fallback(static function () {
    return view('not-found');
});

