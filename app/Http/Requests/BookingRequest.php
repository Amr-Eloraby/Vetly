<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'clinic_id' => 'required|exists:clinics,id',
            'service_type' => 'required|in:consultation,follow_up',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'clinic_id.required' => 'The clinic ID is required.',
            'clinic_id.exists' => 'The selected clinic does not exist.',
            'service_type.required' => 'The service type is required.',
            'service_type.in' => 'The service type must be either consultation or follow_up.',
            'booking_date.required' => 'The booking date is required.',
            'booking_date.date' => 'The booking date must be a valid date.',
            'booking_date.after_or_equal' => 'The booking date must be today or a future date.',
            'booking_time.required' => 'The booking time is required.',
        ];
    }
}
