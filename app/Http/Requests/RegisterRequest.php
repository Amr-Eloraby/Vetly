<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email','ends_with:@vetly.com' ,'max:255', 'unique:' . User::class],
            'phone' => ['required', 'regex:/^01(0|1|2|5)[0-9]{8}$/', 'unique:' . User::class],
            'password' => ['required','regex:/^(?=.*[A-Za-z@#$%^&*!]).{8,}$/' ,'confirmed', Rules\Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.ends_with' => 'Email must end with @vetly.com.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'Email has already been taken.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must be a valid Egyptian mobile number.',
            'phone.unique' => 'Phone number has already been taken.',
            'password.required' => 'Password is required.',
            'password.regex' => 'Password must be at least 8 characters long and contain at least one letter or special character.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}
