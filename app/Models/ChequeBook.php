<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChequeBook extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'cheque_books';
    protected $fillable = [ 'bank_id', 'title', 'slug', 'book_number', 'pages', 'status'];

    //relationship

    public function bank(){
        return $this->belongsTo(Bank::class);
    }
}
