<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alternative\AlternativeDetail as Resource;

use App\Models\AlternativeDetail;

class AlternativeDetailController extends Controller
{
    public function index()
    {
        $alternatives = AlternativeDetail::all();
        return Resource::collection($alternatives);
    }

    public function add(Request $request)
    {
        $request->validate([
            'alternative_id' => 'required|integer',
            'criteria_id' => 'required|integer',
            'value' => 'required'
        ]);

        AlternativeDetail::updateOrCreate(
            ['alternative_id' => $request->alternative_id, 'criteria_id' => $request->criteria_id],
            ['value' => $request->value]
        );

        $alternatives = AlternativeDetail::all();
        return Resource::collection($alternatives);
    }
}
