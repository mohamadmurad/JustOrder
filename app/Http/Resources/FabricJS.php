<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FabricJS extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'label' => $this->name,
            'value' => strval($this->id),
            'code' => $this->code,
        ];
    }
}
