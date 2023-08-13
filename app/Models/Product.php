<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'title', 'slug', 'product_category_id', 'product_unit_id', 'product_brand_id'
    ];

    //relation
    public function productCategory(){
        return $this->belongsTo(ProductCategory::class);
    }

    public function productUnit(){
        return $this->belongsTo(ProductUnit::class);
    }

    public function productBrand(){
        return $this->belongsTo(ProductBrand::class);
    }
}
