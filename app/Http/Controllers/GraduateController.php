<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use Illuminate\Http\Request;

class GraduateController extends Controller
{
    public function index(Request $request)
    {
        $query = Graduate::with(['city.department.country', 'companies', 'academicDegrees', 'knowledgeAreas']);

        // Filtros
        if ($request->has('name')) {
            $query->withName($request->name);
        }
        if ($request->has('email')) {
            $query->withEmail($request->email);
        }
        if ($request->has('city_id')) {
            $query->fromCity($request->city_id);
        }
        if ($request->has('graduation_year')) {
            $query->fromGraduationYear($request->graduation_year);
        }
        if ($request->has('current_company') && $request->current_company) {
            $query->currentCompanyEmployees();
        }
        if ($request->has('academic_degree_id')) {
            $query->withAcademicDegree($request->academic_degree_id);
        }
        if ($request->has('knowledge_area_id')) {
            $query->withKnowledgeArea($request->knowledge_area_id);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 10);
        $graduates = $query->paginate($perPage);

        return response()->json($graduates);
    }

    public function show($id)
    {
        $graduate = Graduate::with(['city.department.country', 'companies', 'academicDegrees', 'knowledgeAreas'])
                          ->findOrFail($id);
        return response()->json($graduate);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:55',
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:150',
            'email' => 'required|email|max:60|unique:graduates,email',
            'linkedin' => 'nullable|string|max:50',
            'facebook_name' => 'nullable|string|max:50',
            'facebook_link' => 'nullable|url|max:80',
            'twitter' => 'nullable|string|max:50',
            'graduation_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'degree_modality' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'company_ids' => 'sometimes|array',
            'company_ids.*' => 'exists:companies,id',
            'academic_degree_ids' => 'sometimes|array',
            'academic_degree_ids.*' => 'exists:academic_degrees,id',
            'knowledge_area_ids' => 'sometimes|array',
            'knowledge_area_ids.*' => 'exists:knowledge_areas,id'
        ]);

        $graduate = Graduate::create($validated);

        // Relaciones muchos a muchos
        if ($request->has('company_ids')) {
            $graduate->companies()->attach($request->company_ids);
        }
        if ($request->has('academic_degree_ids')) {
            $graduate->academicDegrees()->attach($request->academic_degree_ids);
        }
        if ($request->has('knowledge_area_ids')) {
            $graduate->knowledgeAreas()->attach($request->knowledge_area_ids);
        }

        return response()->json($graduate->load(['companies', 'academicDegrees', 'knowledgeAreas']), 201);
    }

    public function update(Request $request, $id)
    {
        $graduate = Graduate::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:55',
            'birth_date' => 'sometimes|required|date',
            'phone' => 'sometimes|required|string|max:50',
            'address' => 'sometimes|required|string|max:150',
            'email' => 'sometimes|required|email|max:60|unique:graduates,email,' . $id,
            'linkedin' => 'nullable|string|max:50',
            'facebook_name' => 'nullable|string|max:50',
            'facebook_link' => 'nullable|url|max:80',
            'twitter' => 'nullable|string|max:50',
            'graduation_year' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1),
            'degree_modality' => 'sometimes|required|string',
            'city_id' => 'sometimes|required|exists:cities,id',
            'company_ids' => 'sometimes|array',
            'company_ids.*' => 'exists:companies,id',
            'academic_degree_ids' => 'sometimes|array',
            'academic_degree_ids.*' => 'exists:academic_degrees,id',
            'knowledge_area_ids' => 'sometimes|array',
            'knowledge_area_ids.*' => 'exists:knowledge_areas,id'
        ]);

        $graduate->update($validated);

        // Sincronizar relaciones muchos a muchos
        if ($request->has('company_ids')) {
            $graduate->companies()->sync($request->company_ids);
        }
        if ($request->has('academic_degree_ids')) {
            $graduate->academicDegrees()->sync($request->academic_degree_ids);
        }
        if ($request->has('knowledge_area_ids')) {
            $graduate->knowledgeAreas()->sync($request->knowledge_area_ids);
        }

        return response()->json($graduate->load(['companies', 'academicDegrees', 'knowledgeAreas']));
    }

    public function destroy($id)
    {
        $graduate = Graduate::findOrFail($id);
        $graduate->delete();
        
        return response()->json(['message' => 'Graduate deleted successfully']);
    }
}
