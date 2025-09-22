<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






use App\Http\Controllers\CountryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AcademicDegreeController;
use App\Http\Controllers\KnowledgeAreaController;
use App\Http\Controllers\GraduateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Countries Routes
Route::apiResource('countries', CountryController::class);
Route::get('countries/search/{name}', [CountryController::class, 'index'])->name('countries.search');

// Departments Routes
Route::apiResource('departments', DepartmentController::class);
Route::get('departments/country/{countryId}', [DepartmentController::class, 'index'])->name('departments.by_country');
Route::get('departments/search/{name}', [DepartmentController::class, 'index'])->name('departments.search');

// Cities Routes
Route::apiResource('cities', CityController::class);
Route::get('cities/department/{departmentId}', [CityController::class, 'index'])->name('cities.by_department');
Route::get('cities/search/{name}', [CityController::class, 'index'])->name('cities.search');

// Companies Routes
Route::apiResource('companies', CompanyController::class);
Route::get('companies/search/{name}', [CompanyController::class, 'index'])->name('companies.search');

// Academic Degrees Routes
Route::apiResource('academic-degrees', AcademicDegreeController::class);
Route::get('academic-degrees/search/{name}', [AcademicDegreeController::class, 'index'])->name('academic-degrees.search');

// Knowledge Areas Routes
Route::apiResource('knowledge-areas', KnowledgeAreaController::class);
Route::get('knowledge-areas/search/{name}', [KnowledgeAreaController::class, 'index'])->name('knowledge-areas.search');

// Graduates Routes
Route::apiResource('graduates', GraduateController::class);
Route::get('graduates/city/{cityId}', [GraduateController::class, 'index'])->name('graduates.by_city');
Route::get('graduates/year/{year}', [GraduateController::class, 'index'])->name('graduates.by_year');
Route::get('graduates/current-company', [GraduateController::class, 'index'])->name('graduates.current_company');
Route::get('graduates/degree/{degreeId}', [GraduateController::class, 'index'])->name('graduates.by_degree');
Route::get('graduates/area/{areaId}', [GraduateController::class, 'index'])->name('graduates.by_area');
Route::get('graduates/search/name/{name}', [GraduateController::class, 'index'])->name('graduates.search.name');
Route::get('graduates/search/email/{email}', [GraduateController::class, 'index'])->name('graduates.search.email');

// Bulk operations for relationships
Route::post('graduates/{graduate}/companies', [GraduateController::class, 'update'])->name('graduates.companies.update');
Route::post('graduates/{graduate}/academic-degrees', [GraduateController::class, 'update'])->name('graduates.degrees.update');
Route::post('graduates/{graduate}/knowledge-areas', [GraduateController::class, 'update'])->name('graduates.areas.update');




//Ultima Prueba del Commit


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
