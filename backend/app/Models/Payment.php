<?php

namespace App\Models;
use App\Models\PaymentMethod;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'payment_method_id', 'amount', 'status', 'created_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
   public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

}
