<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
      //  dd($this);
        return [
            'brand_id' => 'required|exists:brands,id',
            'year_id' => 'required|exists:years,id',
            'type_id' => 'required|exists:types,id',
            'group_id' => 'required|exists:groups,id',
            'subgroup_id' => 'required|exists:subgroups,id',
            'season_id' => 'required|exists:seasons,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'fabricSource_id' => 'required|exists:fabric_sources,id',
            'fabric_id' => 'required|exists:fabrics,id',
            'fabricFormula' => 'nullable|string',
            //'siresQty' => '',
            'siresColorQty' => 'nullable|min:1',
            'siresSizeQty' => 'nullable|min:1',
            //'quantity' => '',
            'reservedQuantity' => 'nullable|min:1',
            //'receivedQty' => 'required|min:1',
            'modelName' => 'nullable|string',
            'modelDesc' => 'nullable|string',
            'notes' => 'nullable|string',
            'fabricDate' => 'nullable|date',

//            'siresNumber' => '',
//            'itemsNumber' => '',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',

            //'reservedDate' => 'required|date',

            'colors' =>  'nullable',
            'colors.*' => 'exists:colors,id',

            'sizes' =>  'nullable',
            'sizes.*' => 'exists:sizes,id'

        ];
    }
}
