<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use App\Mail\NightlyReport;
use Illuminate\Support\Facades\Mail;

class SendNightlyReport extends Command
{
    protected $signature = 'report:nightly';
    protected $description = 'Send nightly orders and revenue report to admin';

    public function handle()
    {
        $startDate = now()->subDay()->startOfDay();
        $endDate = now()->subDay()->endOfDay();

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        $totalRevenue = $orders->sum('total');
        $orderCount = $orders->count();

        Mail::to(config('mail.admin_email'))
            ->send(new NightlyReport($orderCount, $totalRevenue));

        $this->info("Nightly report sent. Orders: $orderCount, Revenue: $totalRevenue");
    }
}