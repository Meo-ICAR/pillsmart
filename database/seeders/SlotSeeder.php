<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slot;
use App\Models\Device;

class SlotSeeder extends Seeder
{
    public function run(): void
    {
        $deviceIds = Device::pluck('id')->all();
        \App\Models\Slot::factory()->count(40)->make()->each(function ($slot) use ($deviceIds) {
            $slot->device_id = fake()->randomElement($deviceIds);
            $slot->save();
        });
    }
}
