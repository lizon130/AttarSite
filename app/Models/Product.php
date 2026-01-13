<?php

namespace App\Models;

use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    
    protected $fillable = [
        'CategoryId',
        'SubCategoryId',
        'ProductName',
        'ProductDetails',
        'Price',
        'OfferPrice',
        'ProductSize',
        'status'
    ];

    protected $casts = [
        'Price' => 'decimal:2',
        'OfferPrice' => 'decimal:2',
        'status' => 'string'
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryId');
    }

    // Relationship with SubCategory
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'SubCategoryId');
    }

    // Accessor for discount percentage
    public function getDiscountPercentageAttribute()
    {
        if ($this->OfferPrice && $this->Price > 0) {
            return round((($this->Price - $this->OfferPrice) / $this->Price) * 100, 2);
        }
        return 0;
    }

    // Accessor for final price
    public function getFinalPriceAttribute()
    {
        return $this->OfferPrice ?: $this->Price;
    }

    // Scope for active products
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope for products with discount
    public function scopeDiscounted($query)
    {
        return $query->whereNotNull('OfferPrice');
    }

    // Scope for products by category
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('CategoryId', $categoryId);
    }

    // Scope for products by subcategory
    public function scopeBySubCategory($query, $subCategoryId)
    {
        return $query->where('SubCategoryId', $subCategoryId);
    }

    // Scope for search
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('ProductName', 'like', '%' . $searchTerm . '%')
                    ->orWhere('ProductDetails', 'like', '%' . $searchTerm . '%');
    }

    // Relationship with ProductImages
public function images()
{
    return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
}

// Relationship with primary image
public function primaryImage()
{
    return $this->hasOne(ProductImage::class, 'product_id')->where('is_primary', true);
}
}