<?php

namespace App\Http\Resources\Criteria;

use Illuminate\Http\Resources\Json\JsonResource;

class CriteriaResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'comparisons' => CriteriaComparisonMatrix::collection($this->comparisonsX),
            'pv' => $this->priority->value ?? 0,
        ];
    }
}
