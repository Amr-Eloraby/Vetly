<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'medicine_id.required' => 'The medicine ID is required.',
            'medicine_id.exists' => 'The selected medicine does not exist.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least 1.',
        ];
    }
}
