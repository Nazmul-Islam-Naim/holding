<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'types';
    protected $fillable = ['title', 'slug'];

    //relation
    public function subTypes(){
        return $this->hasMany(Type::class);
    }
}
