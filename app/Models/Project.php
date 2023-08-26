<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'projects';
    protected $fillable = [
        'title', 'slug', 'location', 'land_owner', 'land_amount', 'land_cost', 'description', 'total_share', 'avatar', 'document', 'status'
    ];

    //relation
    public function shares(){
        return $this->hasMany(ProjectShare::class);
    }

    public function billCollections(){
        return $this->hasMany(ProjectShareholder::class);
    }

    public function stocks(){
        return $this->hasMany(Stock::class);
    }

    public function stockOuts(){
        return $this->hasMany(StockOut::class);
    }

    public function billGenerates(){
        return $this->hasMany(BillGenerate::class);
    }

    public function projectLandPayment(){
        return $this->hasMany(ProjectLandPayment::class);
    }
}
