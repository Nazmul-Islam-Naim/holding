<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;
    protected $table = 'stock_outs';
    protected $fillable = [
        'project_id', 'date', 'note'
    ];

    //relation
    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function stockOutDetails(){
        return $this->hasMany(StockOutDetails::class);
    }
}
