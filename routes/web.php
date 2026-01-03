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


Route::get('/cities', [CityController::class, 'showBasePage'] )->name('cities.index');
Route::get('/cities/getAbc', [CityController::class, 'getAbc'] )->name('cities.getAbc');
Route::get('/cities/{char}', [CityController::class, 'showByCharAndCounty'])->name('cities.showByCharAndCounty');
Route::get('/cities/{city}', [CityController::class, 'show'] )->name('cities.show');
Route::post('/cities', [CityController::class, 'store'] )->name('cities.store');
Route::put('/cities/{city}', [CityController::class, 'update'] )->name('cities.update');
Route::delete('/cities/{city}', [CityController::class, 'destroy'] )->name('cities.destroy');

Route::get('/counties', [CountyController::class, 'index'] )->name('counties.index');
Route::get('/counties/{county}', [CountyController::class, 'show'] )->name('counties.show');
Route::post('/counties', [CountyController::class, 'store'] )->name('counties.store');
Route::put('/counties/{county}', [CountyController::class, 'update'] )->name('counties.update');
Route::delete('/counties/{county}', [CountyController::class, 'destroy'] )->name('counties.destroy');

require __DIR__.'/auth.php';
