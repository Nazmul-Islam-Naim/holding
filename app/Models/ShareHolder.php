<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShareHolder extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'share_holders';
    protected $fillable = [
        'name', 'phone', 'mail', 'avatar', 'nid', 'details', 'bill', 'collection', 'due', 'status'
    ];

    //relation
    public function share(){
        return $this->hasOne(ProjectShare::class);
    }

    public function billCollections(){
        return $this->hasMany(ProjectShareholder::class);
    }
}
