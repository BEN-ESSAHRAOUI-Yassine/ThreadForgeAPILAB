<?php

namespace Database\Factories;

use App\Models\Blueprint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Blueprint>
 */
class BlueprintFactory extends Factory
{
    protected $model = Blueprint::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'rules' => ['rule1', 'rule2'],
            'target_audience' => fake()->word(),
            'tone' => fake()->word(),
            'max_hashtags' => 5,
            'max_caracteres' => 280,
            'allow_emojis' => true,
            'forbidden_words' => ['badword'],
            'regles_supplementaires' => fake()->sentence(),
        ];
    }
}
