<?php

namespace App\Http\Resources\Result;

use Illuminate\Http\Resources\Json\JsonResource;

class CriteriaPriorityResource extends JsonResource
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
            'id' => $this->criteria->id,
            'code' => $this->criteria->code,
            'name' => $this->criteria->name,
            'value' => $this->value
        ];
    }
}
