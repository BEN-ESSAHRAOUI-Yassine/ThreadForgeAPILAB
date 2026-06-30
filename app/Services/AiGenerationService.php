<?php

namespace App\Services;

use App\Models\Blueprint;
use App\Models\RawContent;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use RuntimeException;

use function Laravel\Ai\agent;

class AiGenerationService
{
    public function generate(RawContent $rawContent): array
    {
        $rawContent->loadMissing('blueprint');

        $instructions = $this->buildPrompt($rawContent, $rawContent->blueprint);

        $response = agent(
            schema: fn (JsonSchema $schema) => [
                'hook_propose' => $schema->string()->required(),
                'body_points' => $schema->array()
                    ->items($schema->string())
                    ->required(),
                'technical_readability_score' => $schema->integer()->min(0)->max(100)->required(),
                'suggested_hashtags' => $schema->array()
                    ->items($schema->string())
                    ->required(),
                'tone_compliance_justification' => $schema->string()->required(),
            ],
        )->prompt($instructions);

        return [
            'hook_propose' => $response['hook_propose'],
            'body_points' => $response['body_points'],
            'technical_readability_score' => $response['technical_readability_score'],
            'suggested_hashtags' => $response['suggested_hashtags'],
            'tone_compliance_justification' => $response['tone_compliance_justification'],
        ];
    }

    private function buildPrompt(RawContent $rawContent, Blueprint $blueprint): string
    {
        $rules = collect($blueprint->rules ?? [])->map(fn ($value, $key) => "- {$key}: {$value}")->implode("\n");

        $forbiddenWords = ! empty($blueprint->forbidden_words)
            ? "Forbidden words to avoid:\n" . collect($blueprint->forbidden_words)->map(fn ($word) => "- {$word}")->implode("\n")
            : 'None.';

        $allowEmojis = $blueprint->allow_emojis ? 'Yes' : 'No';

        return <<<PROMPT
You are a social media content strategist specialized in X (Twitter) threads.

Transform the following raw technical content into an optimized X post thread using the provided blueprint rules.

## Raw Content
Title: {$rawContent->title}

Content:
{$rawContent->contenu_brut}

## Blueprint Rules
{$rules}

- Target Audience: {$blueprint->target_audience}
- Tone: {$blueprint->tone}
- Max Hashtags: {$blueprint->max_hashtags}
- Max Characters Per Post: {$blueprint->max_caracteres}
- Allow Emojis: {$allowEmojis}
{$forbiddenWords}

Additional Rules: {$blueprint->regles_supplementaires}

Generate a thread with a compelling hook, 3-5 body points, a technical readability score (0-100), relevant hashtags, and a tone compliance justification.
PROMPT;
    }
}
