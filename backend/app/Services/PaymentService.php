<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Order;
use App\Models\PaymentMethod;
use Exception;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    // public function processPayment(Order $order, array $paymentData)
    // {
    //     if (!isset($paymentData['payment_method_id'])) {
    //         throw new Exception('Payment method is required');
    //     }

    //     $payment = Payment::create([
    //         'order_id' => $order->id,
    //         'payment_method_id' => $paymentData['payment_method_id'],
    //         'amount' => $order->total,
    //         'status' => 'completed',
    //         'created_at' => now()
    //     ]);
    //     $order->status = 'paid';
    //     $order->save();

    //     return $payment;
    // }

    // public function getPaymentStatus(string $paymentId)
    // {
    //     $payment = Payment::findOrFail($paymentId);
    //     return $payment->status;
    // }

    // public function getPaymentMethods()
    // {
    //     return PaymentMethod::all();
    // }
}
