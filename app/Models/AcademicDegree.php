<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AcademicDegree extends Model
{
    use HasFactory;

    protected $fillable = [
        'degree_name'
    ];

    public function graduates(): BelongsToMany
    {
        return $this->belongsToMany(Graduate::class, 'academic_degree_graduate')
                    ->withTimestamps();
    }

    public function scopeWithName($query, $name)
    {
        return $query->where('degree_name', 'like', "%{$name}%");
    }
}