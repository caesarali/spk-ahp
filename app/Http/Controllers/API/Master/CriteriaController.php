<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Master\CriteriaResource;

use App\Models\Criteria;

class CriteriaController extends Controller
{
    public function index()
    {
        $criterias = Criteria::all();
        return CriteriaResource::collection($criterias);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:4|unique:criterias',
            'name' => 'required|string|max:255'
        ]);

        $criteria = Criteria::create($request->all());

        return (new CriteriaResource($criteria))->additional(['message' => 'Criteria Disimpan!']);
    }

    public function update(Request $request, Criteria $criteria)
    {
        $request->validate([
            'code' => 'required|string|max:4|unique:criterias,code,'.$criteria->id,
            'name' => 'required|string|max:255'
        ]);

        $criteria->update($request->all());

        return (new CriteriaResource($criteria))->additional(['message' => 'Perubahan Disimpan!']);
    }

    public function destroy(Criteria $criteria)
    {
        $criteria->forceDelete();
        return response()->json(['message' => 'Criteria Dihapus']);
    }
}
