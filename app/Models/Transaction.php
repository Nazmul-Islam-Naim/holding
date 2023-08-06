<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = ['bank_account_id', 'transactionable_type', 'transactionable_id', 'transaction_type', 'reason', 'amount', 'transaction_date', 'note'];

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }
}
