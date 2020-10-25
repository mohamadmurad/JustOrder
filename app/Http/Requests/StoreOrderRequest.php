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
            'fabricFormula' => 'string',
            //'siresQty' => '',
            'siresColorQty' => 'required|min:1',
            'siresSizeQty' => 'required|min:1',
            //'quantity' => '',
            'reservedQuantity' => 'required|min:1',
            //'receivedQty' => 'required|min:1',
            'modelName' => 'required|string',
            'modelDesc' => 'string',
            'notes' => 'nullable|string',
            'fabricDate' => 'nullable|date',

//            'siresNumber' => '',
//            'itemsNumber' => '',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            //'reservedDate' => 'required|date',

            'colors' =>  'required',
            'colors.*' => 'required|exists:colors,id',

            'sizes' =>  'required',
            'sizes.*' => 'exists:sizes,id'

        ];
    }
}
