<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectShare extends Model
{
    use HasFactory;
    protected $table = 'project_shares';
    protected $fillable = [
        'project_id', 'share_holder_id', 'total_share', 'share_amount', 'total_amount', 'date'
    ];

    //relations
    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function shareHolder(){
        return $this->belongsTo(ShareHolder::class);
    }

    public function bill(){
        return $this->hasOne(ProjectShareholder::class);
    }
}
