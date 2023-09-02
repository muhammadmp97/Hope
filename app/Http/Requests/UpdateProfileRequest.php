<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nick_name' => ['string', 'min:3', 'max:30'],
            'bio' => ['string', 'max:200'],
            'avatar_url' => ['url'],
            'country_id' => ['exists:countries,id'],
            'is_recovered' => ['boolean'],
            'birth_date' => ['date'],
        ];
    }
}
