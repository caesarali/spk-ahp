<?php

namespace App\Http\Controllers\API\Analysis\Criteria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Criteria\CriteriaResource;
use App\Http\Resources\Criteria\CriteriaComparisonSum;
use App\Http\Resources\Master\IndexRandomResource;

use App\Models\Criteria;
use App\Models\CriteriaNormalization;
use App\Models\CriteriaPriority;
use App\Models\IndexRandom;

class CriteriaAnalysisController extends Controller
{
    public function index()
    {
        $criterias = Criteria::orderBy('code', 'asc')->get();
        $matrixMultiplication = [];
        foreach ($criterias as $criteria) {
            $row = [];
            foreach ($criteria->comparisonsX as $item) {
                $value = $item->value;
                $pv = $item->secondCriteria->priority->value;
                $row[] = $value * $pv;
            }
            $matrixMultiplication[] = round(collect($row)->sum(), 4);
        }

        $indexRandom = IndexRandom::orderBy('n', 'asc')->get();

        return CriteriaResource::collection($criterias)->additional([
            'total' => CriteriaComparisonSum::collection($criterias),
            'result' => $matrixMultiplication,
            'index_random' => IndexRandomResource::collection($indexRandom)
        ]);
    }

    public function result()
    {
        $criterias = Criteria::orderBy('code', 'asc')->get();

        foreach ($criterias as $criteria) {
            $total = $criteria->comparisonsY->sum('value');
            foreach ($criteria->comparisonsY as $comparison) {
                $normalization = CriteriaNormalization::updateOrCreate(
                    ['comparison_id' => $comparison->id],
                    ['value' => round($comparison->value / $total, 4)]
                );
            }
        }
        foreach ($criterias as $criteria) {
            $pv = CriteriaPriority::updateOrCreate(
                ['criteria_id' => $criteria->id],
                ['value' => $criteria->comparisonsX->avg('normalization_value')]
            );
        }
        return response()->json(403);
    }
}
