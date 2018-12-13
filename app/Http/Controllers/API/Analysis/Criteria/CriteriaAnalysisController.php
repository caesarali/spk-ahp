<?php

namespace App\Http\Controllers\API\Analysis\Criteria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Criteria\CriteriaResource;
use App\Http\Resources\Criteria\CriteriaComparisonSum;

use App\Models\Criteria;
use App\Models\CriteriaNormalization;
use App\Models\CriteriaPriority;

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
        return CriteriaResource::collection($criterias)->additional([
            'total' => CriteriaComparisonSum::collection($criterias),
            'result' => $matrixMultiplication
        ]);
    }

    public function result()
    {
        $criterias = Criteria::orderBy('code', 'asc')->get();
        foreach ($criterias as $criteria) {
            $total = $criteria->comparisonsY->sum('value');
            foreach ($criteria->comparisonsY as $comparison) {
                CriteriaNormalization::updateOrCreate(
                    ['comparison_id' => $comparison->id],
                    ['value' => round($comparison->value / $total, 4)]
                );
            }
            CriteriaPriority::updateOrCreate(
                ['criteria_id' => $criteria->id],
                ['value' => round($criteria->comparisonsX->avg('normalization_value'), 4)]
            );
        }
        return response()->json(200);
    }
}
