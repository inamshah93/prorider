<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSenderProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'business_name' => 'nullable|string|max:255',
            'pickup_address' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:6|confirmed',
        ];
    }
}
