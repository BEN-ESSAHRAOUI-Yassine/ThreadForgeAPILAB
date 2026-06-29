<?php

namespace App\Http\Requests;

use App\Models\Blueprint;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RawContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'contenu_brut' => ['required', 'string', 'min:1', 'max:512000'],
            'blueprint_id' => [
                'required',
                'integer',
                Rule::exists('blueprints', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'blueprint_id.exists' => 'The selected blueprint does not exist or does not belong to you.',
            'contenu_brut.max' => 'The raw content must not exceed 500KB.',
        ];
    }
}
