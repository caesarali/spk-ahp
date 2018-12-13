<?php

namespace App\Http\Controllers\API\Analysis\Criteria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Criteria\CriteriaComparisonMatrix as Resource;

use App\Models\CriteriaComparison;

class CriteriaComparisonController extends Controller
{
    public function index()
    {
        $comparisons = CriteriaComparison::all();
        return Resource::collection($comparisons);
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
            $comparison = CriteriaComparison::updateOrCreate(
                ['first_criteria_id' => $firstCriteria, 'second_criteria_id' => $secondCriteria],
                ['value' => 1]
            );
        } else {
            $comparison = CriteriaComparison::updateOrCreate(
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
}
