@extends('layouts.dashboard')



@section('module')
    <x-card-header
        :title="__('Stats')"
        :hint="__('dashboard')">
        <x-link-button
            icon="refresh"
            :content="__('Refresh')"
            :link="url()->full()">
        </x-link-button>
    </x-card-header>

    {{-- Platform stats --}}
    <x-box>
        <x-box-header>
            {{ __('Platforms') }}
        </x-box-header>
        <p class="mb-5 text-break text-muted">
            {{ __('Different operating systems that accessed your code.') }}
            {{ __('Nowadays, visits from mobile platforms (Android, iOS, etc)') }}
            {{ __('are better because most devices with these systems have camera to scan codes.') }}
        </p>

        @if ( count($platforms)>0 )
            <stats-platform
                :chart_info='@json($platforms)'>
            </stats-platform>
        @else
            <x-alert type="warning">
                {{ __('There is no data yet') }}
            </x-alert>
        @endif
    </x-box>
    
    {{-- Browser stats --}}
    <x-box>
        <x-box-header>
            {{ __('Browsers') }}
        </x-box-header>
        <p class="mb-5 text-break text-muted">
            {{ __('Different browsers that accessed your code.') }}
        </p>
        @if ( count($browsers)>0 )
            <stats-browser
                :chart_info='@json($browsers)'>
            </stats-browser>
        @else
            <x-alert type="warning">
                {{ __('There is no data yet') }}
            </x-alert>
        @endif
    </x-box>
    
    {{-- Devices stats --}}
    <x-box>
        <x-box-header>
            {{ __('Device types') }}
        </x-box-header>
        <p class="mb-5 text-break text-muted">
            {{ __('Different device types that accessed your code.') }}
            {{ __('More mobile phones is better because the probability that') }}
            {{ __('customers have these types of devices in their pockets is always higher.') }}
        </p>
        @if ( count($deviceTypes)>0 )
            <stats-device
                :chart_info='@json($deviceTypes)'>
            </stats-device>
        @else
            <x-alert type="warning">
                {{ __('There is no data yet') }}
            </x-alert>
        @endif
    </x-box>
    
    {{-- Browser Type stats --}}
    <x-box>
        <x-box-header>
            {{ __('Browser types') }}
        </x-box-header>
        <p class="mb-5 text-break text-muted">
            {{ __('Different browser types that accessed your code.') }}
            {{ __('Most times, your code will be accessed by being scanned and tapped.') }}
            {{ __('Sometimes, the code will be accessed by internal browsers that are included into some apps.') }}
            {{ __('One example for this would be opening a link into some social networks that opens it into their own browser.') }}
            {{ __('This section is useful to know where your code is accessed from.') }}
        </p>
        @if ( count($browserTypes)>0 )
            <stats-browser-type
                :chart_info='@json($browserTypes)'>
            </stats-browser-type>
        @else
            <x-alert type="warning">
                {{ __('There is no data yet') }}
            </x-alert>
        @endif
    </x-box>

    {{-- Last Week stats --}}
    <x-box>
        <x-box-header>
            {{ __('Last week') }}
        </x-box-header>
        <p class="mb-5 text-break text-muted">
            {{ __('Visitors by day in the last week.') }}
            {{ __('This information is useful because it shows the best day of the week to launch a product.') }}
            {{ __('Due to this, data must be taken as a trend.') }}
        </p>
        @if ( count($lastWeek)>0 )
            <stats-last-week
                :chart_info='@json($lastWeek)'>
            </stats-last-week>
        @else
            <x-alert type="warning">
                {{ __('There is no data yet') }}
            </x-alert>
        @endif
    </x-box>

    {{-- Last Month stats --}}
    <x-box>
        <x-box-header>
            {{ __('Last month') }}
        </x-box-header>
        <p class="mb-5 text-break text-muted">
            {{ __('Visitors (left) by day (bottom) in the last month.') }}
            {{ __('This information is useful because it shows the best day of the month to launch a product.') }}
            {{ __('This sample is big enough to trust it.') }}
        </p>
        @if ( count($lastMonth)>0 )
            <stats-last-month
                :chart_info='@json($lastMonth)'>
            </stats-last-month>
        @else
            <x-alert type="warning">
                {{ __('There is no data yet') }}
            </x-alert>
        @endif
    </x-box>

    {{-- Last Year stats --}}
    <x-box>
        <x-box-header>
            {{ __('Last year') }}
        </x-box-header>
        <p class="mb-5 text-break text-muted">
            {{ __('Visitors by month in the last year.') }}
            {{ __('This information is useful because it shows the best month to launch a product.') }}
            {{ __('This sample is big enough to trust it.') }}
        </p>
        @if ( count($lastYear)>0 )
            <stats-last-year
                :chart_info='@json($lastYear)'>
            </stats-last-year>
        @else
            <x-alert type="warning">
                {{ __('There is no data yet') }}
            </x-alert>
        @endif
    </x-box>

@endsection