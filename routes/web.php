<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/artists',\App\Http\Controllers\ArtistController::class);
    Route::post('/artists/import',[\App\Http\Controllers\ArtistController::class,'importExcel'])->name('artists.import');

    Route::resource('/users',\App\Http\Controllers\UserController::class);
    Route::resource('/music',\App\Http\Controllers\MusicController::class);
});

require __DIR__.'/auth.php';
Route::get('/register',\App\Livewire\Auth\Registration::class)->name('register');

Route::get('/log-viewer', function () {


    return view('log');
});
