<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::with('country');

        // Filtros
        if ($request->has('name')) {
            $query->withName($request->name);
        }
        if ($request->has('country_id')) {
            $query->fromCountry($request->country_id);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 10);
        $departments = $query->paginate($perPage);

        return response()->json($departments);
    }

    public function show($id)
    {
        $department = Department::with('country')->findOrFail($id);
        return response()->json($department);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:45',
            'country_id' => 'required|exists:countries,id'
        ]);

        $department = Department::create($validated);
        return response()->json($department, 201);
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:45',
            'country_id' => 'sometimes|required|exists:countries,id'
        ]);

        $department->update($validated);
        return response()->json($department);
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        
        return response()->json(['message' => 'Department deleted successfully']);
    }
}