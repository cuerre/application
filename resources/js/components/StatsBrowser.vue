<template>

    <div>
        <canvas id='stats_browser_chart'></canvas>
    </div>

</template>


<script>

export default {

    name: 'StatsBrowser',
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
                data: Object.values(this.chart_info),
                backgroundColor: icolor.getColors(Object.keys(this.chart_info).length)
            }]
        }

        /* eslint-disable no-new */
        new Chart(document.getElementById('stats_browser_chart'), {
            type: 'horizontalBar',
            data: chartData,
            options: this.options
        })
    }
}

</script>

