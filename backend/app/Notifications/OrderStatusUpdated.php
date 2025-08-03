<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected Order $order;
    protected string $messageText;

    public function __construct(Order $order, string $messageText)
    {
        $this->order       = $order;
        $this->messageText = $messageText;
    }

    public function via($notifiable): array
    {
       
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Order #{$this->order->id} Update")
            ->line($this->messageText)
            ->action('View Your Order', url("/orders/{$this->order->id}"))
            ->line('Thanks for shopping with us!');
    }

    public function toArray($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'status'   => $this->order->status,
            'message'  => $this->messageText,
        ];
    }
}
