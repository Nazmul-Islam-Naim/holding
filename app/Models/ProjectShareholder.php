<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ProjectShareholder extends Model
{
    use HasFactory;
    protected $table = 'project_shareholders';
    protected $fillable = [
        'project_share_id', 'project_id', 'share_holder_id', 'bank_account_id', 'transaction_type', 'amount', 'date', 'note'
    ];

    //relation
    public function projectShare(){
        return $this->belongsTo(ProjectShare::class);
    }
    
    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function shareHolder(){
        return $this->belongsTo(ShareHolder::class);
    }

    public function bankAccount(){
        return $this->belongsTo(BankAccount::class);
    }
    
    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }
}
