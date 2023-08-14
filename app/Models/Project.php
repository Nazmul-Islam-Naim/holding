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
        'title', 'slug', 'location', 'description', 'total_share', 'avatar', 'status'
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
}
