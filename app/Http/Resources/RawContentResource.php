<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RawContentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'blueprint_id' => $this->blueprint_id,
            'title' => $this->title,
            'contenu_brut' => $this->contenu_brut,
            'statut' => $this->statut?->value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'blueprint' => new BlueprintResource($this->whenLoaded('blueprint')),
        ];
    }
}
