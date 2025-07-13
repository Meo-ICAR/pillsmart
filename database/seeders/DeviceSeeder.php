<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;
use App\Models\Patient;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        $patientIds = \App\Models\Patient::pluck('id')->all();
        \App\Models\Device::factory()->count(20)->make()->each(function ($device) use ($patientIds) {
            $device->patient_id = fake()->randomElement($patientIds);
            $device->save();
            // Create at least 5 slots for each device
            for ($i = 0; $i < 5; $i++) {
                $device->slots()->create(\App\Models\Slot::factory()->make()->toArray());
            }
        });
    }
}
