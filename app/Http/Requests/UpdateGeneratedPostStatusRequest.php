<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneratedPostStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'statut' => ['required', 'string', 'in:draft,posted,archived'],
        ];
    }

    public function messages(): array
    {
        return [
            'statut.in' => 'The status must be one of: draft, posted, archived.',
        ];
    }
}
