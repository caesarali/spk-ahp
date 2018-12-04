<?php

namespace App\Http\Resources\Analysis;

use Illuminate\Http\Resources\Json\JsonResource;

class CriteriaComparisonResource extends JsonResource
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
            'first_criteria_id' => $this->first_criteria_id,
            'second_criteria_id' => $this->second_criteria_id,
            'value' => $this->value
        ];
    }
}
