<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $password
 * @property mixed $name
 * @property mixed $email
 */
class UpdateLocationRequest extends FormRequest
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
            'location_id' => 'required|exists:locations,id',
            'name' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'location_id.required' => 'The location field is required.',
            'location_id.exists' => 'The location does not exist.',
            'name.required' => 'The name field is required.',
        ];
    }
}
