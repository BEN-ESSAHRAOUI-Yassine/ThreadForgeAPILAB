<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneratedPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'raw_content_id' => $this->raw_content_id,
            'hook_propose' => $this->hook_propose,
            'body_points' => $this->body_points,
            'technical_readability_score' => $this->technical_readability_score,
            'suggested_hashtags' => $this->suggested_hashtags,
            'tone_compliance_justification' => $this->tone_compliance_justification,
            'statut' => $this->statut?->value,
            'posted_at' => $this->posted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'raw_content' => new RawContentResource($this->whenLoaded('rawContent')),
        ];
    }
}
