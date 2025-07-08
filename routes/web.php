<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DeviceController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('medicines', MedicineController::class);
Route::post('medicines/import-csv', [MedicineController::class, 'importCsv']);
Route::resource('patients', PatientController::class);
Route::resource('devices', DeviceController::class);
