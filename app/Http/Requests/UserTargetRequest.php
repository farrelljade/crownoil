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
            'calls' => ['required', 'integer', 'min:0'],
            'prospects' => ['required', 'integer', 'min:0'],
            'profit' => ['required', 'numeric', 'min:0'],
            'rejuves' => ['required', 'integer', 'min:0'],
            'iho' => ['required', 'integer', 'min:0'],
            'lubricants' => ['required', 'integer', 'min:0'],
            'carbon_offsets' => ['required', 'integer', 'min:0'],
        ];
    }
}
