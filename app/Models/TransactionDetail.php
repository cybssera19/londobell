<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_header_id', 'item_id', 'quantity'];

    public function item() {
        return $this->belongsTo(Item::class);
    }
}
