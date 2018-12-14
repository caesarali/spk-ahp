<?php

namespace App\Http\Resources\Alternative;

use Illuminate\Http\Resources\Json\JsonResource;

class AlternativeDetail extends JsonResource
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
            'alternative_id' => $this->alternative->id,
            'alternative_name' => $this->alternative->name,
            'criteria_id' => $this->criteria->id,
            'criteria_name' => $this->criteria->name,
            'value' => $this->value
        ];
    }
}
