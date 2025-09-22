<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $query = Country::query();

        // Filtros
        if ($request->has('name')) {
            $query->withName($request->name);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 10);
        $countries = $query->paginate($perPage);

        return response()->json($countries);
    }

    public function show($id)
    {
        $country = Country::findOrFail($id);
        return response()->json($country);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $country = Country::create($validated);
        return response()->json($country, 201);
    }

    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100'
        ]);

        $country->update($validated);
        return response()->json($country);
    }

    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $country->delete();
        
        return response()->json(['message' => 'Country deleted successfully']);
    }
}