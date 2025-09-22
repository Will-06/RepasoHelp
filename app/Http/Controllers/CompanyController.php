<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query();

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
        $companies = $query->paginate($perPage);

        return response()->json($companies);
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        $company = Company::create($validated);
        return response()->json($company, 201);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string'
        ]);

        $company->update($validated);
        return response()->json($company);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        
        return response()->json(['message' => 'Company deleted successfully']);
    }
}