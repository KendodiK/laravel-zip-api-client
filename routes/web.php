<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/cities', [CityController::class, 'index'] )->name('cities.index');
Route::get('/cities/{city}', [CityController::class, 'show'] )->name('cities.show');
Route::post('/cities', [CityController::class, 'store'] )->name('cities.store');
Route::put('/cities/{city}', [CityController::class, 'update'] )->name('cities.update');
Route::delete('/cities/{city}', [CityController::class, 'destroy'] )->name('cities.destroy');

Route::get('/counties', [CountyController::class, 'index'] )->name('counties.index');

require __DIR__.'/auth.php';
