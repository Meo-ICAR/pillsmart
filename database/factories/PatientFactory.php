<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'date_of_birth' => $this->faker->date(),
            'breakfast_hour' => $this->faker->time('H:i'),
            'lunch_hour' => $this->faker->time('H:i'),
            'dinner_hour' => $this->faker->time('H:i'),
            'wakeup_hour' => $this->faker->time('H:i'),
            'sleep_hour' => $this->faker->time('H:i'),
            'address' => $this->faker->address(),
            'user_id' => null,
            'anamnesi' => $this->faker->sentence(),
        ];
    }
}
