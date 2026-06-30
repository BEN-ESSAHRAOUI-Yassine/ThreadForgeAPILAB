<?php

namespace App\Ai\Tools;

use App\Models\Blueprint;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetCampaignRules implements Tool
{
    public function description(): Stringable|string
    {
        return 'Retrieve the campaign rules, tone, audience, and style configuration for a given blueprint ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $blueprint = Blueprint::find($request['blueprint_id']);

        if (! $blueprint) {
            return 'Blueprint not found.';
        }

        $forbidden = ! empty($blueprint->forbidden_words)
            ? implode(', ', $blueprint->forbidden_words)
            : 'None';

        return implode("\n", [
            "Title: {$blueprint->title}",
            "Description: {$blueprint->description}",
            "Target Audience: {$blueprint->target_audience}",
            "Tone: {$blueprint->tone}",
            "Max Hashtags: {$blueprint->max_hashtags}",
            "Max Characters: {$blueprint->max_caracteres}",
            "Allow Emojis: " . ($blueprint->allow_emojis ? 'Yes' : 'No'),
            "Forbidden Words: {$forbidden}",
            "Additional Rules: {$blueprint->regles_supplementaires}",
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'blueprint_id' => $schema->integer()->required(),
        ];
    }
}
