<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $fillable = [
        'project_id', 'product_id', 'quantity', 'unit_price'
    ];

    //relation
    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
