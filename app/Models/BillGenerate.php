<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillGenerate extends Model
{
    use HasFactory;
    protected $table = 'bill_generates';
    protected $fillable = [
        'project_id', 'share_holder_id', 'bill_type_id', 'bill', 'collection', 'due', 'date', 'note'
    ];

    //relation
    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function shareHolder(){
        return $this->belongsTo(ShareHolder::class);
    }

    public function billType(){
        return $this->belongsTo(BillType::class);
    }

    public function projectShareholders(){
        return $this->hasMany(ProjectShareholder::class);
    }
}
