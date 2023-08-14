<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LocalSupplierLedger extends Model
{
    protected $table = 'local_supplier_ledgers';
    protected $fillable = [
        'local_supplier_id', 'transactionable_type', 'transactionable_id', 'bank_account_id', 'date', 'reason', 'amount', 'note'
    ];

    //realtionship
    public function localSupplier(){
        return $this->belongsTo(LocalSupplier::class);
    }

    public function bankAccount(){
        return $this->belongsTo(BankAccount::class);
    }

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }
    
    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }
}
