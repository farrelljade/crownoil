<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserTargetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'calls_target' => ['nullable', 'integer'],
            'prospect_target' => ['nullable', 'integer'],
            'profit_target' => ['nullable', 'numeric'],
            'rejuve_target' => ['nullable', 'numeric'],
            'iho_target' => ['nullable', 'numeric'],
            'lubricant_target' => ['nullable', 'numeric'],
        ];
    }
}
