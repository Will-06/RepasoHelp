<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Graduate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'phone',
        'address',
        'email',
        'linkedin',
        'facebook_name',
        'facebook_link',
        'twitter',
        'graduation_year',
        'degree_modality',
        'city_id'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_graduate')
                    ->withPivot('is_current', 'company_area')
                    ->withTimestamps();
    }

    public function academicDegrees(): BelongsToMany
    {
        return $this->belongsToMany(AcademicDegree::class, 'academic_degree_graduate')
                    ->withTimestamps();
    }

    public function knowledgeAreas(): BelongsToMany
    {
        return $this->belongsToMany(KnowledgeArea::class, 'knowledge_area_graduate')
                    ->withTimestamps();
    }

    public function scopeFromCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }

    public function scopeFromGraduationYear($query, $year)
    {
        return $query->where('graduation_year', $year);
    }

    public function scopeWithName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }

    public function scopeWithEmail($query, $email)
    {
        return $query->where('email', 'like', "%{$email}%");
    }

    public function scopeCurrentCompanyEmployees($query)
    {
        return $query->whereHas('companies', function (Builder $query) {
            $query->where('is_current', true);
        });
    }

    public function scopeWithAcademicDegree($query, $degreeId)
    {
        return $query->whereHas('academicDegrees', function (Builder $query) use ($degreeId) {
            $query->where('academic_degree_id', $degreeId);
        });
    }

    public function scopeWithKnowledgeArea($query, $areaId)
    {
        return $query->whereHas('knowledgeAreas', function (Builder $query) use ($areaId) {
            $query->where('knowledge_area_id', $areaId);
        });
    }
}