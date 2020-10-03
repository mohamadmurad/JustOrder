<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubGroupRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('subgroups')
                    ->where('group_id', $this->group_id),
            ],
            'group_id' =>  [
                'required',
                'exists:groups,id',
                Rule::unique('subgroups')
                    ->where('name', $this->name),

            ],
            //'group_id' => 'nullable|exists:groups,id',
        ];
    }
}
