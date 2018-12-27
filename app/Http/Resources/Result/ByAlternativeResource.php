<?php

namespace App\Http\Resources\Result;

use Illuminate\Http\Resources\Json\JsonResource;

class ByAlternativeResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'criteria_priorities' => CriteriaPriorityResource::collection($this->priority->sortBy('criteria.code'))
        ];
    }
}
