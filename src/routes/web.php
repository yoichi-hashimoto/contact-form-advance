<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactSearchController;

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

Route::get('/', [ContactController::class,'index'])->name('contact.index') ;

Route::post('/confirm',[ContactController::class,'confirm']);

Route::post('/contacts/store', [ContactController::class, 'store']);

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register.show');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->middleware('throttle:10,1');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin',[ContactSearchController::class, 'index'])->name('admin');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/contacts', [ContactSearchController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactSearchController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [ContactSearchController::class, 'destroy'])->name('contacts.destroy');
});