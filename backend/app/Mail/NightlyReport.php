<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NightlyReport extends Mailable
{
    use Queueable, SerializesModels;

    public $orderCount;
    public $totalRevenue;

    public function __construct($orderCount, $totalRevenue)
    {
        $this->orderCount = $orderCount;
        $this->totalRevenue = $totalRevenue;
    }

    public function build()
    {
        return $this->markdown('emails.nightly-report', [
            'orderCount' => $this->orderCount,
            'totalRevenue' => $this->totalRevenue,
            'reportDate' => now()->subDay()->format('Y-m-d')
        ])->subject('Nightly Sales Report - ' . now()->subDay()->format('Y-m-d'));
    }
}