@extends('layouts.desk')



@section('module')
    <x-card-header
        :title="__('Stats')"
        :hint="__('desk')">
        <x-link-button
            icon="refresh"
            :content="__('Refresh')"
            :link="url()->full()">
        </x-link-button>
    </x-card-header>

    {{-- Errors --}}
    <x-alert-errors />

    {{-- Messages bag --}}
    <x-alert-messages />

    <div class="row">
        <div class="col mb-5">
            {{-- Platform stats --}}
            <x-box class="h-100">
                <x-box-header>
                    {{ __('Platforms') }}
                </x-box-header>
                @if ( count($platforms)>0 )
                    <stats-platform
                        :chart_info='@json($platforms)'>
                    </stats-platform>
                @else
                    <x-alert type="warning">
                        {{ __('There is no data yet') }}
                    </x-alert>
                @endif
                <p class="mt-5 text-break text-muted">
                    {{ __('Different operating systems that accessed your code.') }}
                    {{ __('Nowadays, visits from mobile platforms (Android, iOS, etc)') }}
                    {{ __('are better because most devices with these systems have camera to scan codes.') }}
                </p>
            </x-box>
        </div>
        <div class="col mb-5">
            {{-- Browser stats --}}
            <x-box class="h-100">
                <x-box-header>
                    {{ __('Browsers') }}
                </x-box-header>
                @if ( count($browsers)>0 )
                    <stats-browser
                        :chart_info='@json($browsers)'>
                    </stats-browser>
                @else
                    <x-alert type="warning">
                        {{ __('There is no data yet') }}
                    </x-alert>
                @endif
                <p class="mt-5 text-break text-muted">
                    {{ __('Different browsers that accessed your code.') }}
                </p>
            </x-box>
        </div>
    </div>

    
    
    <div class="row">
        <div class="col mb-5">
            {{-- Devices stats --}}
            <x-box class="h-100">
                <x-box-header>
                    {{ __('Device types') }}
                </x-box-header>
                @if ( count($deviceTypes)>0 )
                    <stats-device
                        :chart_info='@json($deviceTypes)'>
                    </stats-device>
                @else
                    <x-alert type="warning">
                        {{ __('There is no data yet') }}
                    </x-alert>
                @endif
                <p class="mt-5 text-break text-muted">
                    {{ __('Different device types that accessed your code.') }}
                    {{ __('More mobile phones is better because the probability that') }}
                    {{ __('customers have these types of devices in their pockets is always higher.') }}
                </p>
            </x-box>
        </div>
        <div class="col mb-5">
            {{-- Browser Type stats --}}
            <x-box class="h-100">
                <x-box-header>
                    {{ __('Browser types') }}
                </x-box-header>
                @if ( count($browserTypes)>0 )
                    <stats-browser-type
                        :chart_info='@json($browserTypes)'>
                    </stats-browser-type>
                @else
                    <x-alert type="warning">
                        {{ __('There is no data yet') }}
                    </x-alert>
                @endif
                <p class="mt-5 text-break text-muted">
                    {{ __('Different browser types that accessed your code.') }}
                    {{ __('Most times, your code will be accessed by being scanned and tapped.') }}
                    {{ __('Sometimes, the code will be accessed by internal browsers that are included into some apps.') }}
                    {{ __('One example for this would be opening a link into some social networks that opens it into their own browser.') }}
                    {{ __('This section is useful to know where your code is accessed from.') }}
                </p>
            </x-box>
        </div>
    </div>
    
    

    <div class="row">
        <div class="col mb-5">
            {{-- Last Week stats --}}
            <x-box>
                <x-box-header>
                    {{ __('Last week') }}
                </x-box-header>
                @if ( count($lastWeek)>0 )
                    <stats-last-week
                        :chart_info='@json($lastWeek)'>
                    </stats-last-week>
                @else
                    <x-alert type="warning">
                        {{ __('There is no data yet') }}
                    </x-alert>
                @endif
                <p class="mt-5 text-break text-muted">
                    {{ __('Visitors by day in the last week.') }}
                    {{ __('This information is useful because it shows the best day of the week to launch a product.') }}
                    {{ __('Due to this, data must be taken as a trend.') }}
                </p>
            </x-box>
        </div>
        <div class="col mb-5">
            {{-- Last Month stats --}}
            <x-box>
                <x-box-header>
                    {{ __('Last month') }}
                </x-box-header>
                @if ( count($lastMonth)>0 )
                    <stats-last-month
                        :chart_info='@json($lastMonth)'>
                    </stats-last-month>
                @else
                    <x-alert type="warning">
                        {{ __('There is no data yet') }}
                    </x-alert>
                @endif
                <p class="mt-5 text-break text-muted">
                    {{ __('Visitors (left) by day (bottom) in the last month.') }}
                    {{ __('This information is useful because it shows the best day of the month to launch a product.') }}
                    {{ __('This sample is big enough to trust it.') }}
                </p>
            </x-box>
        </div>
    </div>



    <div class="row">
        <div class="col mb-5">
            {{-- Last Year stats --}}
            <x-box>
                <x-box-header>
                    {{ __('Last year') }}
                </x-box-header>
                @if ( count($lastYear)>0 )
                    <stats-last-year
                        :chart_info='@json($lastYear)'>
                    </stats-last-year>
                @else
                    <x-alert type="warning">
                        {{ __('There is no data yet') }}
                    </x-alert>
                @endif
                <p class="mt-5 text-break text-muted">
                    {{ __('Visitors by month in the last year.') }}
                    {{ __('This information is useful because it shows the best month to launch a product.') }}
                    {{ __('This sample is big enough to trust it.') }}
                </p>
            </x-box>
        </div>
        <div class="col mb-5"></div>
    </div>

@endsection