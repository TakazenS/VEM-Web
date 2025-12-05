<?php

use App\Http\Controllers\ActualiteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RapportsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('accueil');


Route::get('/actualite', [ActualiteController::class, 'index'])->name('actualite');

Route::get('/rapports', [RapportsController::class, 'index'])->name('rapports');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'check.role:administrateur, directeur'])->group(function () {
    Route::get('/dashboard/gestion-utilisateurs', [UserController::class, 'index'])->name('gestion.utilisateurs');

    Route::get('/users', [UserController::class, 'getUsers'])->name('users.get');

    Route::delete('/users/delete', [UserController::class, 'deleteUser'])->name('users.delete');
    Route::get('/users/delete', function () {
        abort(404);
    });

    Route::get('/users/search', [UserController::class, 'searchUsers'])->name('users.search');

    Route::patch('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::get('/users/{user}/update-role', function () {
        abort(404);
    });
});

require __DIR__.'/auth.php';
