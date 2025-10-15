<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'pickup_location_id' => 'nullable|exists:pickup_locations,id',
            'receiver_id' => 'required|exists:receivers,id',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'cod_amount' => 'nullable|numeric|min:0',
            'pickup_address' => 'nullable|string|max:1000',
            'delivery_address' => 'nullable|string|max:1000',
            'weight_kg' => 'nullable|numeric|min:0',
        ];
    }
}
