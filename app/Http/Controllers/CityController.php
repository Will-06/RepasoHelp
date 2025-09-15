<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $query = City::with('department.country');

        // Filtros
        if ($request->has('name')) {
            $query->withName($request->name);
        }
        if ($request->has('department_id')) {
            $query->fromDepartment($request->department_id);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 10);
        $cities = $query->paginate($perPage);

        return response()->json($cities);
    }

    public function show($id)
    {
        $city = City::with('department.country')->findOrFail($id);
        return response()->json($city);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:45',
            'department_id' => 'required|exists:departments,id'
        ]);

        $city = City::create($validated);
        return response()->json($city, 201);
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:45',
            'department_id' => 'sometimes|required|exists:departments,id'
        ]);

        $city->update($validated);
        return response()->json($city);
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        
        return response()->json(['message' => 'City deleted successfully']);
    }
}
