<?php

namespace App\Http\Requests;

use App\Models\order;
use App\Models\reOrder;
use Illuminate\Foundation\Http\FormRequest;

class ReDoneRequest extends FormRequest
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

        $order = reOrder::where('id','=',$this->get('order'))
            ->where('done','=',0)->first();
        return [
            'order' => 'required|exists:re_orders,id',
            'receivedQty' => 'required|numeric'/*|max:'.($order->quantity - $order->receivedQty)*/,
        ];
    }
}
