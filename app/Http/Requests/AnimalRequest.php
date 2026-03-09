<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnimalRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'type' => 'required|in:Dog,Cat,Chicken,Pigeon,Horse,Cow',
            'age' => 'required|in:1 W → 4 W,1 M → 3 M,3 M → 6 M,6 M → 1 Y,1 Y → 2 Y',
        ];
    }
}
