<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bank_accounts';
    protected $fillable = [
        'bank_id', 'account_type_id', 'account_name', 'account_number', 'routing_numer', 'branch', 'opening_date', 'balance', 'status'
    ];

    public function bank(){
        return $this->belongsTo(Bank::class);
    }

    public function accountType(){
        return $this->belongsTo(AccountType::class);
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'bank_account_id');
    }

    public function voucherTransaction(){
        return $this->hasMany(VoucherTransaction::class);
    }

    public function shareCollectios(){
        return $this->hasMany(ProjectShareholder::class);
    }

    public function projectLandPayment(){
        return $this->hasMany(ProjectLandPayment::class);
    }
}
