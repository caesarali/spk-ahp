<?php

namespace App\Http\Resources\Alternative;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Criteria\CriteriaResource;

class AlternativeResource extends JsonResource
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
        ];
    }
}
