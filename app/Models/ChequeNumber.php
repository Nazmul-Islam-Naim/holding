<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChequeNumber extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'cheque_numbers';
    protected $fillable = ['cheque_book_id', 'cheque_number', 'status'];

    //relation

    public function chequeBook(){
        return $this->belongsTo(ChequeBook::class);
    }
}
