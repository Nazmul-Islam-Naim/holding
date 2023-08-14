<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class LocalSupplier extends Model
{
    protected $table = 'local_suppliers';
    protected $fillable = [
        'name', 'phone', 'email', 'address', 'bill', 'payment', 'due'
    ];

    // relationship
    public function preDue(){
        return $this->hasOne(LocalSupplierLedger::class);
    }

    public function ledger(){
        return $this->hasMany(LocalSupplierLedger::class);
    }
    
    public function supplierTransaction(): MorphOne
    {
        return $this->morphOne(LocalSupplierLedger::class, 'transactionable');
    }

}
