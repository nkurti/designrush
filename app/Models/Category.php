<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
    ];

    /**
     * Set slug automatically from name if not provided.
     */
    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function providers()
    {
        return $this->hasMany(Provider::class);
    }

    /**
     * Scope for searching by name.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', '%' . $term . '%');
    }
}
