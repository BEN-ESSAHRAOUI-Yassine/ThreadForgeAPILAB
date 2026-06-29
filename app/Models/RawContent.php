<?php

namespace App\Models;

use App\Enums\RawContentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RawContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blueprint_id',
        'title',
        'contenu_brut',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'statut' => RawContentStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function blueprint(): BelongsTo
    {
        return $this->belongsTo(Blueprint::class);
    }

    public function generatedPost(): HasOne
    {
        return $this->hasOne(GeneratedPost::class);
    }
}
