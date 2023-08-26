<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ProjectLandPayment extends Model
{
    use HasFactory;
    protected $table = 'project_land_payments';
    protected $fillable = [
        'project_id', 'bank_account_id', 'date', 'amount', 'note'
    ];

    //relation
    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function bankAccount(){
        return $this-> belongsTo(BankAccount::class);
    }
    
    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }
}
