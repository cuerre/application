@extends('layouts.dashboard')



@section('module')
    <x-card-header
        title="Stats"
        hint="dashboard">
        <x-link-button
            icon="refresh"
            :content="__('Refresh')"
            :link="url()->full()">
        </x-link-button>
    </x-card-header>

    {{-- Platform stats --}}
    <div class="row my-3 shadow-sm">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Platforms') }}
            </h5>
            <p class="mb-5 text-break text-muted">
                {{ __('Different operating systems that accessed your code.') }}
                {{ __('Nowadays, visits from mobile platforms (Android, iOS, etc)') }}
                {{ __('are better because most devices with these systems have camera to scan codes.') }}
            </p>
            <stats-platform
                :chart_info='@json($platforms)'>
            </stats-platform>
        </div>
    </div>
    
    {{-- Browser stats --}}
    <div class="row my-3 shadow-sm">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Browsers') }}
            </h5>
            <p class="mb-5 text-break text-muted">
                {{ __('Different browsers that accessed your code.') }}
            </p>
            <stats-browser
                :chart_info='@json($browsers)'>
            </stats-browser>
        </div>
    </div>
    
    {{-- Devices stats --}}
    <div class="row my-3 shadow-sm">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Device types') }}
            </h5>
            <p class="mb-5 text-break text-muted">
                {{ __('Different device types that accessed your code.') }}
                {{ __('More mobile phones is better because the probability that') }}
                {{ __('customers have these types of devices in their pockets is always higher.') }}
            </p>
            <stats-device
                :chart_info='@json($deviceTypes)'>
            </stats-device>
        </div>
    </div>
    
    {{-- Browser Type stats --}}
    <div class="row my-3 shadow-sm">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Browser types') }}
            </h5>
            <p class="mb-5 text-break text-muted">
                {{ __('Different browser types that accessed your code.') }}
                {{ __('Most times, your code will be accessed by being scanned and tapped.') }}
                {{ __('Sometimes, the code will be accessed by internal browsers that are included into some apps.') }}
                {{ __('One example for this would be opening a link into some social networks that opens it into their own browser.') }}
                {{ __('This section is useful to know where your code is accessed from.') }}
            </p>
            <stats-browser-type
                :chart_info='@json($browserTypes)'>
            </stats-browser-type>
        </div>
    </div>

    {{-- Last Week stats --}}
    <div class="row my-3 shadow-sm">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Last week') }}
            </h5>
            <p class="mb-5 text-break text-muted">
                {{ __('Visitors by day in the last week.') }}
                {{ __('This information is useful because it shows the best day of the week to launch a product.') }}
                {{ __('Due to this, data must be taken as a trend.') }}
            </p>
            <stats-last-week
                :chart_info='@json($lastWeek)'>
            </stats-last-week>
        </div>
    </div>

    {{-- Last Month stats --}}
    <div class="row my-3 shadow-sm">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Last month') }}
            </h5>
            <p class="mb-5 text-break text-muted">
                {{ __('Visitors (left) by day (bottom) in the last month.') }}
                {{ __('This information is useful because it shows the best day of the month to launch a product.') }}
                {{ __('This sample is big enough to trust it.') }}
            </p>
            <stats-last-month
                :chart_info='@json($lastMonth)'>
            </stats-last-month>
        </div>
    </div>

    {{-- Last Year stats --}}
    <div class="row my-3 shadow-sm">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Last year') }}
            </h5>
            <p class="mb-5 text-break text-muted">
                {{ __('Visitors by month in the last year.') }}
                {{ __('This information is useful because it shows the best month to launch a product.') }}
                {{ __('This sample is big enough to trust it.') }}
            </p>
            <stats-last-year
                :chart_info='@json($lastYear)'>
            </stats-last-year>
        </div>
    </div>
@endsection