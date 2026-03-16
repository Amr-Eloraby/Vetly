<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VaccinationRequest extends FormRequest
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
            'animal_type' => 'required|string|max:255',
            'start_age_weeks' => 'required|integer|min:0',
            'end_age_weeks' => 'required|integer|min:0',
            'is_repeatable' => 'required|boolean',
            'repeat_every_weeks' => 'nullable|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vaccination name is required',
            'name.string' => 'Vaccination name must be a string',
            'name.max' => 'Vaccination name must be less than 255 characters',
            'animal_type.required' => 'Animal type is required',
            'animal_type.string' => 'Animal type must be a string',
            'animal_type.max' => 'Animal type must be less than 255 characters',
            'start_age_weeks.required' => 'Start age is required',
            'start_age_weeks.integer' => 'Start age must be an integer',
            'start_age_weeks.min' => 'Start age must be greater than or equal to 0',
            'end_age_weeks.required' => 'End age is required',
            'end_age_weeks.integer' => 'End age must be an integer',
            'end_age_weeks.min' => 'End age must be greater than or equal to 0',
            'is_repeatable.required' => 'Is repeatable is required',
            'is_repeatable.boolean' => 'Is repeatable must be a boolean',
            'repeat_every_weeks.required' => 'Repeat every weeks is required',
            'repeat_every_weeks.integer' => 'Repeat every weeks must be an integer',
            'repeat_every_weeks.min' => 'Repeat every weeks must be greater than or equal to 0',
        ];
    }
}
