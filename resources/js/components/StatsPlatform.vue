<template>

    <div>
        <canvas id='stats_platforms_chart'></canvas>
    </div>

</template>


<script>

export default {

    name: 'StatsPlatform',
    data: function () {
        return {
            options : {
                legend: {
                    display: true
                },
                responsive: true,
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
        new Chart(document.getElementById('stats_platforms_chart'), {
            type: 'doughnut',
            data: chartData,
            options: this.options
        })
    }
}

</script>

