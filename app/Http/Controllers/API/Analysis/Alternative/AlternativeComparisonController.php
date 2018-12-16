<?php

namespace App\Http\Controllers\API\Analysis\Alternative;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alternative\AlternativeComparison as Resource;

use App\Models\AlternativeComparison;

class AlternativeComparisonController extends Controller
{
    public function index() {
        $comparisons = AlternativeComparison::all();
        return Resource::collection($comparisons);
    }

    public function store(Request $request)
    {
        $request->validate([
            'criteria_id' => 'required|integer',
            'x_alternative_id' => 'required|integer',
            'y_alternative_id' => 'required|integer',
            'value' => 'required|integer',
        ]);
        $criteriaId = $request->criteria_id;
        $alternativeX = $request->x_alternative_id;
        $alternativeY = $request->y_alternative_id;
        if ($alternativeX == $alternativeY) {
            $comparison = AlternativeComparison::updateOrCreate(
                ['criteria_id' => $criteriaId, 'x_alternative_id' => $alternativeX, 'y_alternative_id' => $alternativeY],
                ['value' => 1]
            );
        } else {
            $comparison = alternativeComparison::updateOrCreate(
                ['criteria_id' => $criteriaId, 'x_alternative_id' => $alternativeX, 'y_alternative_id' => $alternativeY],
                ['value' => $request->value]
            );
            $invers = AlternativeComparison::updateOrCreate(
                ['criteria_id' => $criteriaId, 'x_alternative_id' => $alternativeY, 'y_alternative_id' => $alternativeX],
                ['value' => 1 / $request->value]
            );
        }
        return response()->json(['message' => 'Pembobotan disimpan!']);
    }
}
