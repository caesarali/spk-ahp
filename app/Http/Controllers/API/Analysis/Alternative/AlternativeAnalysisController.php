<?php

namespace App\Http\Controllers\API\Analysis\Alternative;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        //////////////////////////////////////////////////////////////////////////////
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
                ['value' => round($alternative->comparisonsX->avg('normalization_value'), 4)]
            );
        }
        return response()->json(200);
    }

    public function result()
    {

    }

    public function resultAll()
    {

    }
}
