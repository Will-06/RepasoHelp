<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeArea;
use Illuminate\Http\Request;

class KnowledgeAreaController extends Controller
{
    public function index(Request $request)
    {
        $query = KnowledgeArea::query();

        // Filtros
        if ($request->has('area_name')) {
            $query->withName($request->area_name);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 10);
        $areas = $query->paginate($perPage);

        return response()->json($areas);
    }

    public function show($id)
    {
        $area = KnowledgeArea::findOrFail($id);
        return response()->json($area);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_name' => 'required|string'
        ]);

        $area = KnowledgeArea::create($validated);
        return response()->json($area, 201);
    }

    public function update(Request $request, $id)
    {
        $area = KnowledgeArea::findOrFail($id);
        
        $validated = $request->validate([
            'area_name' => 'sometimes|required|string'
        ]);

        $area->update($validated);
        return response()->json($area);
    }

    public function destroy($id)
    {
        $area = KnowledgeArea::findOrFail($id);
        $area->delete();
        
        return response()->json(['message' => 'Knowledge area deleted successfully']);
    }
}