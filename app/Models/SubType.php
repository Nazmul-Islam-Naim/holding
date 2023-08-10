<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sub_types';
    protected $fillable = ['type_id', 'title', 'slug'];

    //relation
    public function type(){
        return $this->belongsTo(Type::class);
    }
}
