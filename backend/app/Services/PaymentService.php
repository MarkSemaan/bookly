<?

namespace App\Services;

use App\Models\Payment;
use App\Models\Order;

class PaymentService
{
    public function processPayment(Order $order, array $paymentData) {}

    public function getPaymentStatus(string $paymentId) {}
}
