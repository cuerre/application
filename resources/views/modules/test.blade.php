@extends('layouts.dashboard')



@section('module')
    <!--<canvas id="myChart[0]" width="400" height="400"></canvas>-->

@endsection



@push('scripts')

    var ctx = document.getElementById('myChart[0]');

    var myCharti = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'caca'],
            datasets: [{
                label: '# of visits',
                data: [12, 19, 3, 5, 2, 3, 3, 4, 7, 10, 30],
                borderColor: [
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1,
                fill: 'origin'
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });


@endpush
