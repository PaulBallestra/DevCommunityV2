<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth'])->name('dashboard');
Route::get('/profil', function () { return view('profil'); })->middleware(['auth'])->name('profil');

Route::get('/edit', [\App\Http\Controllers\UserprofilController::class, 'edit' ]) ->name('editprofil')->middleware(['auth']);
Route::put('/edit', [\App\Http\Controllers\UserprofilController::class, 'update' ]) ->name('update');

//Route::post('contact', [\App\Http\Controllers\ContactController::class, 'store' ]) ->name('store');
require __DIR__.'/auth.php';
