<?php

namespace App\Http\Resources\Alternative;

use Illuminate\Http\Resources\Json\JsonResource;

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
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'detail' => AlternativeDetail::collection($this->details)
        ];

        if ($request->criteria) {
            $data['comparisons'] = AlternativeComparison::collection(
                $this->comparisonsX->where('criteria_id', $request->criteria->id)->sortBy('alternativeY.code')
            );
            $data['pv'] = $this->priority->where('criteria_id', $request->criteria->id)->first()->value;
        }

        return $data;
    }
}
