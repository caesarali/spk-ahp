<?php

namespace App\Http\Resources\Alternative;

use Illuminate\Http\Resources\Json\JsonResource;

class AlternativeComparisonSum extends JsonResource
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
            'total_comparison' => round($this->comparisonsY->where('criteria_id', $request->criteria->id)->sum('value'), 5),
            'total_normalization' => round($this->comparisonsY->where('criteria_id', $request->criteria->id)->sum('normalization_value'))
        ];
    }
}
