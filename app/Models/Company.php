<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function graduates(): BelongsToMany
    {
        return $this->belongsToMany(Graduate::class, 'company_graduate')
                    ->withPivot('is_current', 'company_area')
                    ->withTimestamps();
    }

    public function scopeWithName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }
}