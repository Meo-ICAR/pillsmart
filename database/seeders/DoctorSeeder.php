<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\User;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id')->all();
        \App\Models\Doctor::factory()->count(10)->make()->each(function ($doctor) use ($userIds) {
            $doctor->user_id = fake()->randomElement($userIds);
            $doctor->save();
        });
    }
}
