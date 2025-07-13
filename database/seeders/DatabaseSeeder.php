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
        $this->call([
            UserSeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
            CaregiverSeeder::class,
            MedicineSeeder::class,
            PrescriptionSeeder::class,
            DeviceSeeder::class,
            SlotSeeder::class,
            DoctorPatientSeeder::class,
            CaregiverPatientSeeder::class,
        ]);
    }
}
