<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'prospect_id' => 'required|exists:prospects,id',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'ppl_cost' => 'required|numeric|min:0',
            'ppl_sell' => 'required|numeric|min:0',
            'vat' => 'required|numeric|min:0',
            'nett_total' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'ppl_profit' => 'required|numeric|min:0',
            'total_profit' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'prospect_id.required' => 'The prospect field is required.',
            'user_id.required' => 'The user field is required.',
            'product_id.required' => 'The product field is required.',
            'quantity.required' => 'The quantity field is required.',
            'ppl_sell.required' => 'The PPL sell field is required.',
        ];
    }
}
