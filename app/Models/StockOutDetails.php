<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOutDetails extends Model
{
    use HasFactory;
    protected $table = 'stock_out_details';
    protected $fillable = [
        'stock_out_id', 'product_id', 'quantity', 'unit_price'
    ];

    //relation
    public function stockOut(){
        return $this->belongsTo(StockOut::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
