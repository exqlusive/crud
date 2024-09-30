<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $password
 * @property mixed $name
 * @property mixed $email
 */
class UpdateReservationRequest extends FormRequest
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
            'arrival_date' => 'required|date',
            'departure_date' => 'required|date|after:arrival_date',
            'number_of_guests' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'arrival_date.required' => 'The arrival date field is required.',
            'arrival_date.date' => 'The arrival date must be a date.',
            'departure_date.required' => 'The departure date field is required.',
            'departure_date.date' => 'The departure date must be a date.',
            'number_of_guests.required' => 'The number of guests field is required.',
            'number_of_guests.integer' => 'The number of guests must be an integer.',
        ];
    }
}
