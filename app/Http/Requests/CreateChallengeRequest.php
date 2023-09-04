<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateChallengeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'text' => ['nullable', 'min:0', 'max:160'],
        ];
    }
}
