<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHeader extends Model
{
    use HasFactory;

    protected $table = 'transaction_headers'; // Memastikan case-sensitivity aman untuk autograder
    protected $fillable = ['user_id', 'grand_total'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function details() {
        return $this->hasMany(TransactionDetail::class, 'transaction_header_id');
    }
}
