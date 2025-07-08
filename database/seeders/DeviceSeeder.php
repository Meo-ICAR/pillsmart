<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;
use App\Models\Patient;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        $patientIds = Patient::pluck('id')->all();
        \App\Models\Device::factory()->count(20)->make()->each(function ($device) use ($patientIds) {
            $device->patient_id = fake()->randomElement($patientIds);
            $device->save();
        });
    }
}
