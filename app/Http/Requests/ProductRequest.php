<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'product_name'     => 'required|string|max:255',
            'battery_percentage' => 'nullable|integer|min:0|max:100',
            // IMEI should be 15 digits
            'product_imei'     => 'required|digits:15',

            'brand'            => 'required|integer|exists:brands,id',
            'series'           => 'required|integer|exists:series,id',
            'color'            => 'required|integer|exists:colors,id',
            'model_type'       => 'required|integer|exists:model_types,id',
            'condition'        => 'required|string|max:255',
            'percentage' => 'nullable|integer|min:0|max:100',
            'storage'          => 'required|integer|exists:storages,id',
            'note' => 'nullable|string|max:1000',
            'type_of_machine'  => 'required|string|max:255',

            // only required when type_of_machine = 2
            'network'          => 'nullable|required_if:type_of_machine,2',

            'purchase_price'   => 'required|numeric|min:0',

            // allow empty selling price
            'selling_price'    => 'nullable|numeric|min:0',

            'purchase_date'    => 'required|date',

            'status'           => 'required|string|max:255',
        ];
    }
}