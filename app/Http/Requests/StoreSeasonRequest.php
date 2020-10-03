<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSeasonRequest extends FormRequest
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
                Rule::unique('seasons')
                    ->where('year_id', $this->year_id),
            ],
            'year_id' =>  [
                'required',
                'exists:years,id',
                Rule::unique('seasons')
                    ->where('name', $this->name),

            ],
            'start' => [
                'date',
                'required',
                'before:end',
            ],
            'end' => [
                'date',
                'required',
                'after:start',
            ],
        ];
    }
}
