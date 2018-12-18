<?php

namespace App\Http\Controllers\API\Analysis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\AnalysisResultResource as Resource;
use App\Http\Resources\Criteria\CriteriaResource;

use App\Models\Alternative;
use App\Models\Criteria;

class ResultController extends Controller
{
    public function index()
    {
        $criterias = Criteria::orderBy('code', 'asc')->get();
        $alternatives = Alternative::orderBy('code', 'asc')->get();
        return Resource::collection($alternatives)->additional([
            'criterias' => CriteriaResource::collection($criterias)
        ]);
    }
}
