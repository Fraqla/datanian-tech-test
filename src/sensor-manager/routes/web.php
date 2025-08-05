<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\StationManager;
use App\Livewire\SensorManager;

Route::get('/', function () {
    return view('welcome');
});

// Route for Station Manager page
Route::get('/station', StationManager::class)->name('station');
// Route for Sensor Manager page
Route::get('/sensor', SensorManager::class)->name('sensor');