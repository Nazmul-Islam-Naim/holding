<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'bill_types';
    protected $fillable = [
        'title'
    ];

    public function billGenerates(){
        return $this->hasMany(BillGenerate::class);
    }

    public function projectShareholder(){
        return $this->hasMany(ProjectShareholder::class);
    }
}
