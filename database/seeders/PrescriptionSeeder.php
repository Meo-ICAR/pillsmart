<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Doctor;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $patientIds = Patient::pluck('id')->all();
        $doctorIds = Doctor::pluck('id')->all();
        \App\Models\Prescription::factory()->count(30)->make()->each(function ($prescription) use ($patientIds, $doctorIds) {
            $prescription->patient_id = fake()->randomElement($patientIds);
            $prescription->doctor_id = fake()->randomElement($doctorIds);
            $prescription->save();
        });
    }
}
