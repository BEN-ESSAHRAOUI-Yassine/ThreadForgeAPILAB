<?php

namespace Database\Factories;

use App\Enums\GeneratedPostStatus;
use App\Models\RawContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeneratedPostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'raw_content_id' => RawContent::factory(),
            'hook_propose' => $this->faker->sentence(),
            'body_points' => $this->faker->sentences(3),
            'technical_readability_score' => $this->faker->numberBetween(0, 100),
            'suggested_hashtags' => $this->faker->words(3),
            'tone_compliance_justification' => $this->faker->sentence(),
            'payload_brut' => [
                'hook_propose' => $this->faker->sentence(),
                'body_points' => $this->faker->sentences(3),
                'technical_readability_score' => $this->faker->numberBetween(0, 100),
                'suggested_hashtags' => $this->faker->words(3),
                'tone_compliance_justification' => $this->faker->sentence(),
            ],
            'statut' => GeneratedPostStatus::Draft,
            'posted_at' => null,
        ];
    }

    public function posted(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => GeneratedPostStatus::Posted,
            'posted_at' => now(),
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => GeneratedPostStatus::Archived,
        ]);
    }
}
