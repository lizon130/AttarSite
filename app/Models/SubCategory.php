<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';
    
    protected $fillable = [
        'categoryId',
        'SubCategoryName',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    // Relationship with Products
    public function products()
    {
        return $this->hasMany(Product::class, 'SubCategoryId');
    }

    // Scope for active subcategories
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope to filter by category
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('categoryId', $categoryId);
    }
}