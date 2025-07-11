<?php

namespace Database\Factories;

use App\Models\CompteBancaire;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CompteBancaireFactory extends Factory
{
    protected $model = CompteBancaire::class;

    public function definition(): array
    {
        return [
            'numero_compte' => $this->faker->word(),
            'code_banque' => $this->faker->word(),
            'code_guichet' => $this->faker->word(),
            'cle_rib' => $this->faker->word(),
            'solde' => $this->faker->randomFloat(),
            'type_compte' => $this->faker->word(),
            'justification' => $this->faker->word(),
            'statut' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'statut_compte' => $this->faker->word(),

            'user_id' => User::factory(),
        ];
    }
}
