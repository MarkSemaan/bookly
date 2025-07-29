<?php

namespace App\Models;
use App\Models\PaymentMethod;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    
   public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

}
