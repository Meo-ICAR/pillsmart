<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caregiver;
use App\Models\Patient;

class CaregiverPatientSeeder extends Seeder
{
    public function run(): void
    {
        $caregiverIds = Caregiver::pluck('id')->all();
        $patientIds = Patient::pluck('id')->all();
        $used = [];
        for ($i = 0; $i < 20; $i++) {
            $caregiver_id = fake()->randomElement($caregiverIds);
            $patient_id = fake()->randomElement($patientIds);
            $key = $caregiver_id.'-'.$patient_id;
            if (!isset($used[$key])) {
                $from = fake()->dateTimeBetween('-2 years', 'now');
                $to = fake()->dateTimeBetween($from, '+1 year');
                \DB::table('caregiver_patient')->insert([
                    'caregiver_id' => $caregiver_id,
                    'patient_id' => $patient_id,
                    'fromdate' => $from,
                    'todate' => $to,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ]);
                $used[$key] = true;
            }
        }
    }
}
