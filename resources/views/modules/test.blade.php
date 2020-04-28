@extends('layouts.dashboard')



@section('module')
    <x-card-header
        title="Statistics"
        hint="dashboard">
        <x-link-button
            icon="refresh"
            :content="__('Refresh')"
            :link="url()->current()">
        </x-link-button>

    </x-card-header>


    <div class="row my-3">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Last week') }}
            </h5>
            <p class="mb-5 text-break text-muted">
                {{ __('Visitors by day in the last week.') }}
                {{ __('This information is useful because it shows the best day of the week to launch a product.') }}
                {{ __('Due to this, data must be taken as a trend.') }}
            </p>
            <canvas id="chart[4]"></canvas>
        </div>
    </div>

    <div class="row my-3">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Last month') }}
            </h5>
            <p class="mb-5 text-break text-muted">
                {{ __('Visitors by day in the last month.') }}
                {{ __('This information is useful because it shows the best day of the month to launch a product.') }}
                {{ __('This sample is big enough to trust it.') }}
            </p>
            <canvas id="chart[5]"></canvas>
        </div>
    </div>

    <div class="row my-3">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Platforms') }}
            </h5>
            <p class="mb-5 text-break text-muted">
                {{ __('Different operating systems that accessed your code.') }}
                {{ __('Nowadays, visits from mobile platforms (Android, iOS, etc)') }}
                {{ __('are better because most devices with these systems have camera to scan codes.') }}
            </p>
            <canvas id="chart[0]"></canvas>
        </div>
    </div>
    
    
    <div class="row my-3">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Browsers') }}
            </h5>
            <p class="mb-5 text-break text-muted">
                {{ __('Different browsers that accessed your code.') }}
            </p>
            <canvas id="chart[1]"></canvas>
        </div>
    </div>
    
    
    <div class="row my-3">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Device types') }}
            </h5>
            <p class="mb-5 text-break text-muted">
                {{ __('Different device types that accessed your code.') }}
                {{ __('More mobile phones is better because the probability that') }}
                {{ __('customers have these types of devices in their pockets is always higher.') }}
            </p>
            <canvas id="chart[2]"></canvas>
        </div>
    </div>
    
    
    <div class="row my-3">
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
            <canvas id="chart[3]"></canvas>
        </div>
    </div>
@endsection



@push('scripts')

    
    
    
    var ctx = {
        platforms: document.getElementById('chart[0]'),
        browsers: document.getElementById('chart[1]'),
        deviceTypes: document.getElementById('chart[2]'),
        browserTypes: document.getElementById('chart[3]'),
        lastWeek: document.getElementById('chart[4]'),
        lastMonth: document.getElementById('chart[5]'),
    };
    
    // Set general options
    let data = [];
    let options = {
        responsive: true,
        legend: {
            display: false,
        },
        scales: {
            xAxes: [{
                stacked: true
            }],
            yAxes: [{
                stacked: true
            }]
        }
    }
    
    
    // Generate chart data
    data = {
        platforms : {
            datasets: [{
                backgroundColor: color.randomSeveral(@php echo count($platforms->values()) @endphp),
                data: @json($platforms->values())
            }],
            labels: @json($platforms->keys()),
        },
        browsers : {
            datasets: [{
                backgroundColor: color.randomSeveral(@php echo count($browsers->values()) @endphp),
                data: @json($browsers->values())
            }],
            labels: @json($browsers->keys()),
        },
        deviceTypes : {
            datasets: [{
                backgroundColor: color.randomSeveral(@php echo count($deviceTypes->values()) @endphp),
                data: @json($deviceTypes->values())
            }],
            labels: @json($deviceTypes->keys()),
        },
        browserTypes : {
            datasets: [{
                backgroundColor: color.randomSeveral(@php echo count($browserTypes->values()) @endphp),
                data: @json($browserTypes->values())
            }],
            labels: @json($browserTypes->keys()),
        },
        lastWeek : {
            datasets: [{
                pointRadius: 5,
                hoverRadius: 4,
                fill: 'origin',
                backgroundColor: color.randomSeveral(@php echo count($lastWeek->values()) @endphp),
                data: @json($lastWeek->values())
            }],
            labels: @json($lastWeek->keys()),
        },
        lastMonth : {
            datasets: [{
                pointRadius: 5,
                hoverRadius: 4,
                fill: 'origin',
                backgroundColor: color.randomSeveral(@php echo count($lastMonth->values()) @endphp),
                data: @json($lastMonth->values())
            }],
            labels: @json($lastMonth->keys()),
        },
        
    };

    var lastWeek = new Chart(ctx.lastWeek, {
        type: 'line',
        data: data.lastWeek,
        options: options
    });

    var lastMonth = new Chart(ctx.lastMonth, {
        type: 'line',
        data: data.lastMonth,
        options: options
    });
    
    
    var platforms = new Chart(ctx.platforms, {
        type: 'horizontalBar',
        data: data.platforms,
        options: options
    });
    
    var browsers = new Chart(ctx.browsers, {
        type: 'horizontalBar',
        data: data.browsers,
        options: options
    });
    
    var deviceTypes = new Chart(ctx.deviceTypes, {
        type: 'horizontalBar',
        data: data.deviceTypes,
        options: options
    });
    
    var browserTypes = new Chart(ctx.browserTypes, {
        type: 'horizontalBar',
        data: data.browserTypes,
        options: options
    });
    
    
    
    
    
    

    


@endpush
