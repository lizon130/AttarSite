<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    
    protected $fillable = [
        'categoryName',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    // Relationship with SubCategories
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'categoryId');
    }

    // Relationship with Products
    public function products()
    {
        return $this->hasMany(Product::class, 'CategoryId');
    }

    // Scope for active categories
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}