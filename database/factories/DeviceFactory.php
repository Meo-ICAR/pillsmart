<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'mac' => $this->faker->macAddress(),
            'nslots' => $this->faker->numberBetween(1, 10),
            'annotations' => $this->faker->sentence(),
            'patient_id' => null,
            'istoupdate' => $this->faker->boolean(),
            'updated_at' => $this->faker->dateTime(),
            'pinged_at' => $this->faker->dateTime(),
        ];
    }
}
