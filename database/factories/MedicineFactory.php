<?php

namespace Database\Factories;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    protected $model = Medicine::class;

    public function definition()
    {
        return [
            'codice_aic' => $this->faker->uuid(),
            'cod_farmaco' => $this->faker->uuid(),
            'cod_confezione' => $this->faker->uuid(),
            'denominazione' => $this->faker->word(),
            'descrizione' => $this->faker->sentence(),
            'codice_ditta' => $this->faker->uuid(),
            'ragione_sociale' => $this->faker->company(),
            'stato_amministrativo' => $this->faker->word(),
            'tipo_procedura' => $this->faker->word(),
            'forma' => $this->faker->word(),
            'codice_atc' => $this->faker->word(),
            'pa_associati' => $this->faker->word(),
            'link' => $this->faker->url(),
        ];
    }
}
