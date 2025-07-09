<?php

namespace Database\Factories;

use App\Models\Caregiver;
use Illuminate\Database\Eloquent\Factories\Factory;

class CaregiverFactory extends Factory
{
    protected $model = Caregiver::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'kind' => $this->faker->word(),
            'user_id' => null,
        ];
    }
}
