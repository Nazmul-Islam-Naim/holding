<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'vouchers';

    /** user_id = created_by */
    protected $fillable = [
        'code', 'type_id', 'sub_type_id', 'voucher_type', 'bearer', 'amount', 'due', 'date', 'note', 'user_id'
    ];

    //relation
    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function subType(){
        return $this->belongsTo(SubType::class);
    }

    public function voucherTransaction(){
        return $this->hasOne(VoucherTransaction::class);
    }

    public function voucherTransactions(){
        return $this->hasMany(VoucherTransaction::class);
    }
    
    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }
}
