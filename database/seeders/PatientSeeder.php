<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Illuminate\Support\Str;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Patient::factory()->count(20)->create();
    }
}
