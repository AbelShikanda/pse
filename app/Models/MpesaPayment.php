<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpesaPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_request_id',
        'checkout_request_id',
        'result_code',
        'result_desc',
        'amount',
        'mpesa_receipt_number',
        'transaction_date',
        'phone_number',
        'status',
    ];
}
