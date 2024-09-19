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
            'targets' => 'required|array',
            'targets.*.calls_target' => 'nullable|integer|min:0',
            'targets.*.prospect_target' => 'nullable|integer|min:0',
            'targets.*.profit_target' => 'nullable|integer|min:0',
            'targets.*.rejuve_target' => 'nullable|integer|min:0',
            'targets.*.iho_target' => 'nullable|integer|min:0',
            'targets.*.lubricant_target' => 'nullable|integer|min:0',
        ];
    }
}
