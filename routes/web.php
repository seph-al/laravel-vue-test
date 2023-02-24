<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/contacts',[ContactsController::class,'index'])->name('topics.index');
Route::post('/contacts',[ContactsController::class,'save'])->name('contacts.save');
Route::get('/contacts/create',[ContactsController::class,'create'])->name('contacts.create');
Route::put('/contacts/{contact}',[ContactsController::class,'update'])->name('contacts.update');
Route::delete('/contacts/{contact}',[ContactsController::class,'destroy'])->name('contacts.destroy');
Route::get('/contacts/{contact}/edit',[ContactsController::class,'edit'])->name('contacts.edit');


Route::get('/users',[UserController::class,'index'])->name('users.index');
Route::post('/users',[UserController::class,'save'])->name('users.save');
Route::get('/users/create',[UserController::class,'create'])->name('users.create');
Route::put('/users/{user}',[UserController::class,'update'])->name('users.update');
Route::delete('/users/{user}',[UserController::class,'destroy'])->name('users.destroy');
Route::get('/users/{user}/edit',[UserController::class,'edit'])->name('users.edit');

Route::get('/organization',[OrganizationController::class,'index'])->name('organization.index');
Route::post('/organization',[OrganizationController::class,'save'])->name('organization.save');
Route::get('/organization/create',[OrganizationController::class,'create'])->name('organization.create');
Route::put('/organization/{organization}',[OrganizationController::class,'update'])->name('organization.update');
Route::delete('/organization/{organization}',[OrganizationController::class,'destroy'])->name('organization.destroy');
Route::get('/organization/{organization}/edit',[OrganizationController::class,'edit'])->name('organization.edit');
Route::get('/organization/{organization}/table',[OrganizationController::class,'table'])->name('organization.table');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
