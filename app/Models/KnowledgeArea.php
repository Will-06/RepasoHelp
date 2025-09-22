<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class KnowledgeArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_name'
    ];

    public function graduates(): BelongsToMany
    {
        return $this->belongsToMany(Graduate::class, 'knowledge_area_graduate')
                    ->withTimestamps();
    }

    public function scopeWithName($query, $name)
    {
        return $query->where('area_name', 'like', "%{$name}%");
    }
}