<?php

namespace Database\Factories;

use App\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrescriptionFactory extends Factory
{
    protected $model = Prescription::class;

    public function definition()
    {
        return [
            'patient_id' => null,
            'doctor_id' => null,
            'medicine' => $this->faker->word(),
            'dosage' => $this->faker->word(),
            'frequency' => $this->faker->word(),
            'date_prescribed' => $this->faker->date(),
            'instructions' => $this->faker->sentence(),
        ];
    }
}
