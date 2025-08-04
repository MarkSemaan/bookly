<?php

namespace App;

use App\Models\Analytic;
use DateTime;
use Carbon\Carbon;

class AnalyticService
{
    public static function saveOrUpdateAnalytic($revenue, $createdAt)
    {
        $hour = Carbon::parse($createdAt)->format('Y-m-d H:00:00');

        $analytic = Analytic::where('hour', $hour)->first();

        if ($analytic) {
            $analytic->increment('orders_count');
            $analytic->increment('revenue', $revenue);
        } else {
            Analytic::create([
                'hour' => $hour,
                'orders_count' => 1,
                'revenue' => $revenue,
            ]);
        }
    }


}
