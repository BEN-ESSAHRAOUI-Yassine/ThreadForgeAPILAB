<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blueprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'rules',
        'target_audience',
        'tone',
        'max_hashtags',
        'max_caracteres',
        'allow_emojis',
        'forbidden_words',
        'regles_supplementaires',
    ];

    protected function casts(): array
    {
        return [
            'rules' => 'array',
            'forbidden_words' => 'array',
            'allow_emojis' => 'boolean',
            'max_hashtags' => 'integer',
            'max_caracteres' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
