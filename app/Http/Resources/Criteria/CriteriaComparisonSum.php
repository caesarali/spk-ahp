<?php

namespace App\Http\Resources\Criteria;

use Illuminate\Http\Resources\Json\JsonResource;

class CriteriaComparisonSum extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'total' => round($this->comparisonsY->sum('value'), 4),
            'total_normalization' => round($this->comparisonsY->sum('normalization_value'))
        ];
    }
}
