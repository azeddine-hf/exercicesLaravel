<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/',[\App\Http\Controllers\CountryController::class, 'index'])->name('home');

Route::get('countires', [\App\Http\Controllers\CountryController::class, 'index'])->name('countries');
Route::post('storeCountries', [\App\Http\Controllers\CountryController::class, 'store'])->name('countries.store');

Route::get('cities', [\App\Http\Controllers\CityController::class, 'index'])->name('cities');
Route::post('storeCities', [\App\Http\Controllers\CityController::class, 'store'])->name('cities.store');

Route::get('people', [\App\Http\Controllers\PersonController::class, 'index'])->name('persons');
Route::post('storePeople', [\App\Http\Controllers\PersonController::class, 'store'])->name('persons.store');



Route::get('/countries/{country}/cities', [\App\Http\Controllers\CountryController::class, 'showCities'])->name('countries.cities');
Route::get('/people/{city}/cities', [\App\Http\Controllers\CityController::class, 'showPeople'])->name('people.cities');
