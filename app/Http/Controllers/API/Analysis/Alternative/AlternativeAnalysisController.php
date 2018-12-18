<?php

namespace App\Http\Controllers\API\Analysis\Alternative;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alternative\AlternativeResource;
use App\Http\Resources\Alternative\AlternativeComparisonSum;

use App\Models\Criteria;
use App\Models\Alternative;
use App\Models\AlternativeNormalization;
use App\Models\AlternativePriority;

class AlternativeAnalysisController extends Controller
{
    public function analyze(Criteria $criteria)
    {
        $alternatives = Alternative::orderBy('code', 'asc')->get();

        // Cek apakah nilai matriks perbandingan berpasangan sudah lengkap atau belum
        $requiredOrdo = pow($alternatives->count(), 2);
        $availableOrdo = $criteria->alternativeComparisons->count();
        if ($requiredOrdo != $availableOrdo) {
            return response()->json('Matriks Perbandingan Berpasangan Belum Lengkap.', 403);
        }

        foreach ($alternatives as $alternative) {
            $comparisons = $alternative->comparisonsY->where('criteria_id', $criteria->id);
            $total = $comparisons->sum('value');
            foreach ($comparisons as $comparison) {
                AlternativeNormalization::updateOrCreate(
                    ['comparison_id' => $comparison->id],
                    ['value' => round($comparison->value / $total, 5)]
                );
            }
            AlternativePriority::updateOrCreate(
                ['criteria_id' => $criteria->id, 'alternative_id' => $alternative->id],
                ['value' => round($alternative->comparisonsX->avg('normalization_value'), 5)]
            );
        }
        return response()->json(200);
    }

    public function result(Criteria $criteria)
    {
        $alternatives = Alternative::orderBy('code', 'asc')->get();

        // Cek apakah nilai matriks perbandingan berpasangan sudah lengkap atau belum
        $requiredOrdo = pow($alternatives->count(), 2);
        $availableOrdo = $criteria->alternativeComparisons->count();
        if ($requiredOrdo != $availableOrdo) {
            return response()->json('Matriks Perbandingan Berpasangan Belum Lengkap.', 403);
        }

        $matrixMultiplication = [];
        foreach ($alternatives as $alternative) {
            $comparisons = $alternative->comparisonsX->where('criteria_id', $criteria->id);
            $row = [];
            foreach ($comparisons as $item) {
                $value = $item->value;
                $pv = $item->alternativeY->priority->where('criteria_id', $criteria->id)->first()->value;
                $row[] = $value * $pv;
            }
            $matrixMultiplication[] = round(collect($row)->sum(), 5);
        }

        return AlternativeResource::collection($alternatives)->additional([
            'matrix_sum_result' => AlternativeComparisonSum::collection($alternatives),
            'matrix_multiplication_result' => $matrixMultiplication,
            'by_criteria' => $criteria->name
        ]);
    }

    public function resultAll()
    {

    }
}
