<template>

    <div>
        <canvas id='stats_last_year_chart'></canvas>
    </div>

</template>


<script>

export default {

    name: 'StatsLastYear',
    data: function () {
        return {
            options : {
                legend: {
                    display: false
                },
                responsive: true,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            suggestedMin: 50,
                            maxTicksLimit:3
                        }
                    }]
                }
            }
        }
    },
    props: {
        chart_info: Object
    },
    mounted: function () {

        let chartData = {
            labels: Object.keys(this.chart_info),
            datasets: [{
                pointRadius: 8,
                hoverRadius: 6,
                fill: 'origin',
                data: Object.values(this.chart_info),
                backgroundColor: icolor.getColors(Object.keys(this.chart_info).length)
            }]
        }

        /* eslint-disable no-new */
        new Chart(document.getElementById('stats_last_year_chart'), {
            type: 'line',
            data: chartData,
            options: this.options
        })
    }
}

</script>

