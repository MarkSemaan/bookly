<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected Order $order;
    protected string $messageText;

    public function __construct(Order $order, string $messageText)
    {
        $this->order = $order->load('items.book');
        $this->messageText = $messageText;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
 
        $booksList = $this->order->items->map(function ($item) {
            return "{$item->book->title} (Qty: {$item->quantity})";
        })->implode("\n");

        $total = number_format($this->order->total, 2);

        return (new MailMessage)
            ->subject("Invoice for Order #{$this->order->id}")
            ->greeting("Hello {$notifiable->name},")
            ->line($this->messageText)
            ->line("Here is a summary of your order:")
            ->line($booksList)
            ->line("**Total Paid:** \${$total}")
            ->action('View your order', url("/orders/{$this->order->id}"))
            ->line('Thank you for your purchase!');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
            'message' => $this->messageText,
            'items' => $this->order->items->map(function ($item) {
                return [
                    'title' => $item->book->title,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            }),
            'total' => $this->order->total,
        ];
    }
}