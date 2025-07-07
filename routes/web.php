<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('medicines', MedicineController::class);
Route::post('medicines/import-csv', [MedicineController::class, 'importCsv']);
