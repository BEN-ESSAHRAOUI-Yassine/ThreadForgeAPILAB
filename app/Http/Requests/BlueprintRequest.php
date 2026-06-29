<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlueprintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'rules' => ['nullable', 'array'],
            'rules.*' => ['string'],
            'target_audience' => ['nullable', 'string', 'max:255'],
            'tone' => ['nullable', 'string', 'max:255'],
            'max_hashtags' => ['nullable', 'integer', 'min:0', 'max:50'],
            'max_caracteres' => ['nullable', 'integer', 'min:1', 'max:10000'],
            'allow_emojis' => ['nullable', 'boolean'],
            'forbidden_words' => ['nullable', 'array'],
            'forbidden_words.*' => ['string'],
            'regles_supplementaires' => ['nullable', 'string'],
        ];
    }
}
