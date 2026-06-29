<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlueprintResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'rules' => $this->rules,
            'target_audience' => $this->target_audience,
            'tone' => $this->tone,
            'max_hashtags' => $this->max_hashtags,
            'max_caracteres' => $this->max_caracteres,
            'allow_emojis' => $this->allow_emojis,
            'forbidden_words' => $this->forbidden_words,
            'regles_supplementaires' => $this->regles_supplementaires,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
