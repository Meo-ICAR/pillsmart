<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Arr;

class DoctorPatientSeeder extends Seeder
{
    public function run(): void
    {
        $doctorIds = Doctor::pluck('id')->all();
        $patientIds = Patient::pluck('id')->all();
        $used = [];
        for ($i = 0; $i < 20; $i++) {
            $doctor_id = fake()->randomElement($doctorIds);
            $patient_id = fake()->randomElement($patientIds);
            $key = $doctor_id.'-'.$patient_id;
            if (!isset($used[$key])) {
                \DB::table('doctor_patient')->insert([
                    'doctor_id' => $doctor_id,
                    'patient_id' => $patient_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $used[$key] = true;
            }
        }
    }
}
