<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register',\App\Livewire\Auth\Registration::class)->name('register');

Route::middleware(['auth','verified'])->group(function () {
   Route::view('/dashboard','dashboard')->name('dashboard');

   Route::controller(\App\Http\Controllers\ArtistController::class)->group(function(){
        Route::resource('/artists',\App\Http\Controllers\ArtistController::class);
        Route::post('/artists/import',[\App\Http\Controllers\ArtistController::class,'importExcel'])->name('artists.import');
        Route::get('/artists/{id}/music',[\App\Http\Controllers\ArtistController::class, 'music'])->name('artists.music');
   });

    Route::resource('/users',\App\Http\Controllers\UserController::class);
    Route::resource('/music',\App\Http\Controllers\MusicController::class);

    Route::get('/activity-log',[LogController::class,'activityLog'])->name('activity.log');
    Route::delete('/activity-log/delete',[LogController::class,'activityLogDestroy'])->name('activity.destroy');

});

