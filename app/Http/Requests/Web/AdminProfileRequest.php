<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class AdminProfileRequest extends FormRequest
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
            'name'     => ['nullable', 'string', 'max:255'],
            'email'    => ['nullable', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users', 'email')->ignore($this->user()->id)],
            'phone'    => ['nullable', 'string', 'regex:/^01(0|1|2|5)[0-9]{8}$/'],
            'password' => ['nullable', 'string', 'min:6'],
        ];
    }
}
