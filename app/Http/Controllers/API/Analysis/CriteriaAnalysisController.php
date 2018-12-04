<?php

namespace App\Http\Controllers\API\Analysis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Analysis\CriteriaComparisonResource as Resource;

use App\Models\CriteriaComparison;

class CriteriaAnalysisController extends Controller
{
    public function index()
    {
        $comparisonMatrix = CriteriaComparison::orderBy('first_criteria_id', 'asc')->get();
        return Resource::collection($comparisonMatrix);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_criteria_id' => 'required|integer',
            'second_criteria_id' => 'required|integer',
            'value' => 'required|integer',
        ]);
        $firstCriteria = $request->first_criteria_id;
        $secondCriteria = $request->second_criteria_id;
        if ($firstCriteria == $secondCriteria) {
            $matrix = CriteriaComparison::updateOrCreate(
                ['first_criteria_id' => $firstCriteria, 'second_criteria_id' => $secondCriteria],
                ['value' => 1]
            );
        } else {
            $matrix = CriteriaComparison::updateOrCreate(
                ['first_criteria_id' => $firstCriteria, 'second_criteria_id' => $secondCriteria],
                ['value' => $request->value]
            );
            $invers = CriteriaComparison::updateOrCreate(
                ['first_criteria_id' => $secondCriteria, 'second_criteria_id' => $firstCriteria],
                ['value' => 1 / $request->value]
            );
        }
        return response()->json(['message' => 'Pembobotan disimpan!']);
    }

    public function result()
    {

    }
}
