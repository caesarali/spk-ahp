<?php

namespace App\Http\Resources\Result;

use Illuminate\Http\Resources\Json\JsonResource;

class AlternativePriorityResource extends JsonResource
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
            'id' => $this->alternative->id,
            'code' => $this->alternative->code,
            'name' => $this->alternative->name,
            'value' => $this->value
        ];
    }
}
