<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class reOrderrequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_id' => 'required|exists:orders,id',

            'siresColorQty' => 'nullable|min:1',
            'siresSizeQty' => 'nullable|min:1',
            'siresQty' => 'nullable|min:1',

            'notes' => 'nullable|string',
            'fabricDate' => 'nullable|date',
            'orderDate' => 'nullable|date',

            'colors' =>  'nullable',
            'colors.*' => 'exists:colors,id',

            'sizes' =>  'nullable',
            'sizes.*' => 'exists:sizes,id'



        ];
    }
}
