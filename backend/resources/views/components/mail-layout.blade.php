@component('mail::message')
# Nightly Sales Report

**Date:** {{ $reportDate }}  
**Orders Processed:** {{ $orderCount }}  
**Total Revenue:** ${{ number_format($totalRevenue, 2) }}

@component('mail::button', ['url' => route('admin.dashboard')])
View Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent