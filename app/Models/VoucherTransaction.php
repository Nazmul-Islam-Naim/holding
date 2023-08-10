<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class VoucherTransaction extends Model
{
    use HasFactory;
    protected $table = 'voucher_transactions'; 
    protected $fillable = [
        'voucher_id', 'bank_account_id', 'voucher_type', 'date', 'amount', 'note'
    ];

    //relation
    public function voucher(){
        return $this->belongsTo(Voucher::class);
    }

    public function bankAccount(){
        return $this->belongsTo(BankAccount::class);
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }
}
