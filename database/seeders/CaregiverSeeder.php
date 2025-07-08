<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caregiver;
use App\Models\User;

class CaregiverSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id')->all();
        \App\Models\Caregiver::factory()->count(10)->make()->each(function ($caregiver) use ($userIds) {
            $caregiver->user_id = fake()->randomElement($userIds);
            $caregiver->save();
        });
    }
}
