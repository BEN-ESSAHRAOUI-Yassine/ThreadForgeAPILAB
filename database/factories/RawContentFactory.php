<?php

namespace Database\Factories;

use App\Models\Blueprint;
use App\Models\RawContent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RawContent>
 */
class RawContentFactory extends Factory
{
    protected $model = RawContent::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'blueprint_id' => Blueprint::factory(),
            'title' => fake()->sentence(4),
            'contenu_brut' => fake()->paragraphs(3, true),
            'statut' => 'pending',
        ];
    }
}
