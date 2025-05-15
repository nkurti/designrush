<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo',
        'category_id',
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'logo' => 'string',
        'category_id' => 'integer',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Accessor: short description
    public function getShortDescriptionAttribute(): string
    {
        return Str::limit($this->description, 100);
    }

    // Accessor: logo full URL
    public function getLogoUrlAttribute(): string
    {
        return asset('storage/' . $this->logo);
    }

    // Mutator: auto-capitalize name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::title($value);
    }

    /**
     * Scope for filtering by category ID or slug.
     */
    public function scopeFilterByCategory($query, $category)
    {
        return $query->whereHas('category', function ($q) use ($category) {
            $q->where('slug', $category)->orWhere('id', $category);
        });
    }

    /**
     * Scope for keyword search in name or description.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', '%' . $term . '%')
              ->orWhere('description', 'like', '%' . $term . '%');
        });
    }
}
