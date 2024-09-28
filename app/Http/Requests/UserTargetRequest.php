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
            'user_id' => ['required', 'exists:users,id'],
            'calls' => ['nullable', 'integer', 'min:0'],
            'prospects' => ['nullable', 'integer', 'min:0'],
            'profit' => ['nullable', 'numeric', 'min:0'],
            'rejuves' => ['nullable', 'integer', 'min:0'],
            'iho' => ['nullable', 'integer', 'min:0'],
            'lubricants' => ['nullable', 'integer', 'min:0'],
            'carbon_offsets' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
