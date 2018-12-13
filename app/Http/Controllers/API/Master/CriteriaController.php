<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Criteria\CriteriaResource as Resource;

use App\Models\Criteria;
use App\Models\CriteriaComparison;

class CriteriaController extends Controller
{
    public function index()
    {
        $criterias = Criteria::all();
        return Resource::collection($criterias);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:4|unique:criterias',
            'name' => 'required|string|max:255'
        ]);

        $criteria = Criteria::create($request->all());
        $comparison = CriteriaComparison::updateOrCreate(
            ['first_criteria_id' => $criteria->id, 'second_criteria_id' => $criteria->id],
            ['value' => 1]
        );

        return (new Resource($criteria))->additional(['message' => 'Criteria Disimpan!']);
    }

    public function update(Request $request, Criteria $criteria)
    {
        $request->validate([
            'code' => 'required|string|max:4|unique:criterias,code,'.$criteria->id,
            'name' => 'required|string|max:255'
        ]);

        $criteria->update($request->all());

        return (new Resource($criteria))->additional(['message' => 'Perubahan Disimpan!']);
    }

    public function destroy(Criteria $criteria)
    {
        $criteria->forceDelete();
        return response()->json(['message' => 'Criteria Dihapus']);
    }
}
