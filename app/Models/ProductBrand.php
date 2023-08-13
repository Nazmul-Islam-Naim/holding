<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBrand extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'product_brands';
    protected $fillable = [
        'title', 'slug'
    ];
    
    //relation
    public function products(){
        return $this->hasMany(Product::class);
    }
}
