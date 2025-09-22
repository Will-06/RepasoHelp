<?php

namespace App\Http\Controllers;

use App\Models\AcademicDegree;
use Illuminate\Http\Request;

class AcademicDegreeController extends Controller
{
    public function index(Request $request)
    {
        $query = AcademicDegree::query();

        // Filtros
        if ($request->has('degree_name')) {
            $query->withName($request->degree_name);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 10);
        $degrees = $query->paginate($perPage);

        return response()->json($degrees);
    }

    public function show($id)
    {
        $degree = AcademicDegree::findOrFail($id);
        return response()->json($degree);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'degree_name' => 'required|string'
        ]);

        $degree = AcademicDegree::create($validated);
        return response()->json($degree, 201);
    }

    public function update(Request $request, $id)
    {
        $degree = AcademicDegree::findOrFail($id);
        
        $validated = $request->validate([
            'degree_name' => 'sometimes|required|string'
        ]);

        $degree->update($validated);
        return response()->json($degree);
    }

    public function destroy($id)
    {
        $degree = AcademicDegree::findOrFail($id);
        $degree->delete();
        
        return response()->json(['message' => 'Academic degree deleted successfully']);
    }
}