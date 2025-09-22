<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department_id'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function graduates(): HasMany
    {
        return $this->hasMany(Graduate::class);
    }

    public function scopeFromDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeWithName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }
}