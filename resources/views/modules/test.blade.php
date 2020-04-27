@extends('layouts.dashboard')



@section('module')
    <x-card-header
        title="Statistics"
        hint="dashboard">
    </x-card-header>


    <div class="row my-3">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">Platforms</h5>
            <p class="mb-5 text-break text-muted">
                Different operating systems that accessed your code
            </p>
            
            <canvas id="chart[0]"></canvas>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-lg bg-light p-4">
            {{ $browsers->keys() }}
            {{ $browsers->values() }}
        </div>
        <div class="col-lg border">
            {{ $deviceTypes->keys() }}
            {{ $deviceTypes->values() }}
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg bg-light p-4">
            {{ $browserTypes->keys() }}
            {{ $browserTypes->values() }}
        </div>
    </div>
@endsection



@push('scripts')

    class color {
    
        // Return a random color in HSL
        static randomHSL = function (){
            return "hsla(" + ~~(360 * Math.random()) + "," +
                            "70%,"+
                            "80%,1)"
        }
        
        // Returns an array of HSL colors
        static randomSeveral = function (num){
            let x = [];
            for( let i = num; i--; ){
              x[i] = this.randomHSL();
            }
            return x;
        }
    }
    
    
    var ctx = document.getElementById('chart[0]');
    
    // Set general options
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
    
    
    // Generate platforms chart
    let data = {
        datasets: [{
            backgroundColor: color.randomSeveral(@php echo count($systems->values()) @endphp),
            data: @json($systems->values())
        }],
        labels: @json($systems->keys()),
    }
    
    
    var platforms = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
    });
    
    
    
    

    


@endpush
