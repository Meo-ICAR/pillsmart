<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorPatientController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\CaregiverPatientController;
use App\Http\Controllers\PrescriptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('medicines', MedicineController::class);
Route::post('medicines/import-csv', [MedicineController::class, 'importCsv']);
Route::resource('patients', PatientController::class);
Route::resource('devices', DeviceController::class);
Route::resource('slots', SlotController::class);
Route::resource('doctors', DoctorController::class);
Route::resource('caregivers', CaregiverController::class);
Route::resource('prescriptions', PrescriptionController::class);
Route::get('doctor-patients', [DoctorPatientController::class, 'index'])->name('doctor-patients.index');
Route::post('doctor-patients', [DoctorPatientController::class, 'store'])->name('doctor-patients.store');
Route::delete('doctor-patients/{id}', [DoctorPatientController::class, 'destroy'])->name('doctor-patients.destroy');
Route::get('caregiver-patients', [CaregiverPatientController::class, 'index'])->name('caregiver-patients.index');
Route::post('caregiver-patients', [CaregiverPatientController::class, 'store'])->name('caregiver-patients.store');
Route::delete('caregiver-patients/{id}', [CaregiverPatientController::class, 'destroy'])->name('caregiver-patients.destroy');
Route::post('caregiver-patients/{id}/restore', [CaregiverPatientController::class, 'restore'])->name('caregiver-patients.restore');
