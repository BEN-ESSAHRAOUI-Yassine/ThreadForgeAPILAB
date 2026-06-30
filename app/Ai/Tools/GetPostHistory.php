<?php

namespace App\Ai\Tools;

use App\Models\GeneratedPost;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetPostHistory implements Tool
{
    public function description(): Stringable|string
    {
        return 'Retrieve the content and metadata of a previously generated post by its ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $post = GeneratedPost::with('rawContent.blueprint')->find($request['post_id']);

        if (! $post) {
            return 'Post not found.';
        }

        $bodyPoints = is_array($post->body_points)
            ? implode("\n", array_map(fn ($p, $i) => ($i + 1) . ". {$p}", $post->body_points, array_keys($post->body_points)))
            : 'None';

        $hashtags = is_array($post->suggested_hashtags)
            ? implode(' ', $post->suggested_hashtags)
            : 'None';

        return implode("\n", [
            "Post ID: {$post->id}",
            "Hook: {$post->hook_propose}",
            "Body Points:",
            $bodyPoints,
            '',
            "Readability Score: {$post->technical_readability_score}",
            "Hashtags: {$hashtags}",
            "Tone Justification: {$post->tone_compliance_justification}",
            "Status: {$post->statut?->value}",
            "Posted At: " . ($post->posted_at ? $post->posted_at->toIso8601String() : 'Not posted'),
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'post_id' => $schema->integer()->required(),
        ];
    }
}
