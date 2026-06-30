<?php

namespace App\Services;

use App\Models\Blueprint;

class BlueprintService
{
    public function duplicate(Blueprint $original, int $userId): Blueprint
    {
        $clone = $original->replicate();
        $clone->user_id = $userId;
        $clone->title = $original->title . ' (copy)';
        $clone->save();

        return $clone;
    }
}
