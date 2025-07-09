<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed users
        $users = User::factory(20)->create();

        // 2. Seed doctors, each linked to a user
        $doctors = $users->take(10)->map(function ($user) {
            return Doctor::factory()->create(['user_id' => $user->id]);
        });

        // 3. Seed patients, each linked to a user
        $patients = $users->slice(10)->map(function ($user) {
            return Patient::factory()->create(['user_id' => $user->id]);
        });

        // 4. Seed prescriptions, linking to existing patients and doctors
        foreach (range(1, 30) as $i) {
            $patient = $patients->random();
            $doctor = $doctors->random();
            Prescription::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->user_id, // doctor_id references users.id
            ]);
        }
    }
}
