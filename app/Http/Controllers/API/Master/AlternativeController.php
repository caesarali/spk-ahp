<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Alternative\AlternativeResource;

use App\Models\Alternative;

class AlternativeController extends Controller
{
    public function index()
    {
        $alternatives = Alternative::orderBy('code', 'asc')->get();
        return AlternativeResource::collection($alternatives);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:4|unique:alternatives',
            'name' => 'required|string|max:255'
        ]);

        $alternative = Alternative::create($request->all());

        return (new AlternativeResource($alternative))->additional(['message' => 'Alternatif Disimpan!']);
    }

    public function update(Request $request, Alternative $alternative)
    {
        $request->validate([
            'code' => 'required|string|max:4|unique:alternatives,code,'.$alternative->id,
            'name' => 'required|string|max:255'
        ]);

        $alternative->update($request->all());

        return (new AlternativeResource($alternative))->additional(['message' => 'Perubahan Disimpan!']);
    }

    public function destroy(Alternative $alternative)
    {
        $alternative->forceDelete();
        return response()->json(['message' => 'Alternatif Dihapus']);
    }
}
