<?php

namespace App\Http\Requests;

use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reportable_type' => ['required', Rule::in(array_keys(Report::REPORTABLE_TYPES))],
            'reportable_id' => ['required', 'numeric'],
            'text' => ['required', 'string', 'min:5', 'max:160'],
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'reportable_type' => Report::REPORTABLE_TYPES[$this->reportable_type],
        ]);
    }
}
