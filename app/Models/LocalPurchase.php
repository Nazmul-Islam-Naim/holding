<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class LocalPurchase extends Model
{
    protected $table = 'local_purchases';
    protected $fillable = [
        'local_supplier_id', 'project_id', 'amount', 'date', 'note', 'status', 'created_by'
    ];

    // relationship
    public function supplier(){
        return $this->belongsTo(LocalSupplier::class, 'local_supplier_id');
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function purchaseDetails(){
        return $this->hasMany(LocalPurchaseDetails::class);
    }
    
    public function supplierTransaction(): MorphOne
    {
        return $this->morphOne(LocalSupplierLedger::class, 'transactionable');
    }

}
