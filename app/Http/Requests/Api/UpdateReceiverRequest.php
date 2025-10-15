<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReceiverRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:150',
            'phone' => 'sometimes|required|string|max:20',
            'address' => 'nullable|string|max:1000',
            'zone_id' => 'nullable|exists:zones,id',
        ];
    }
}
