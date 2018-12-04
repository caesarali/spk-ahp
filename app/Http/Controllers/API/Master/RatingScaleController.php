<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Master\RatingScaleResource;

use App\Models\RatingScale;

class RatingScaleController extends Controller
{
    public function index()
    {
        $scales = RatingScale::orderBy('value', 'asc')->get();
        return RatingScaleResource::collection($scales);
    }
}
