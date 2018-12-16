<?php

namespace App\Http\Resources\Alternative;

use Illuminate\Http\Resources\Json\JsonResource;

class AlternativeComparison extends JsonResource
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
            'id' => $this->id,
            'criteria_id' => $this->criteria_id,
            'x_alternative_id' => $this->x_alternative_id,
            'y_alternative_id' => $this->y_alternative_id,
            'value' => $this->value,
            'normalization_value' => $this->normalization_value
        ];
    }
}
