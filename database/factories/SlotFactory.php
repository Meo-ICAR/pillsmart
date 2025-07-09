<?php

namespace Database\Factories;

use App\Models\Slot;
use Illuminate\Database\Eloquent\Factories\Factory;

class SlotFactory extends Factory
{
    protected $model = Slot::class;

    public function definition()
    {
        return [
            'device_id' => null,
            'n' => $this->faker->numberBetween(1, 10),
            'operhour' => $this->faker->time('H:i'),
            'npill' => $this->faker->numberBetween(1, 5),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
