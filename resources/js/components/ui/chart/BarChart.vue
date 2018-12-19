<template>
    <canvas ref="myChart" style="min-height: 400px"></canvas>
</template>

<script>
export default {
    props: {
        chartLabels: Array,
        chartValue: Array,
    },
    mounted() {
        let labels = this.chartLabels;
        let value = this.chartValue;
        let chartData = {
            labels  : labels,
            datasets: [
                {
                    label : 'Alternatif',
                    borderColor : '#bee5eb',
                    backgroundColor : '#bee5eb',
                    data : value
                },
            ]
        }
        let chartOptions = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero        : true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines      : true,
            //String - Colour of the grid lines
            scaleGridLineColor      : 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth      : 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines  : true,
            //Boolean - If there is a stroke on each bar
            barShowStroke           : true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth          : 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing         : 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing       : 1,
            //String - A legend template
            legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to make the chart responsive
            responsive              : true,
            maintainAspectRatio     : false
        }

        new Chart(this.$refs.myChart, {
            type: 'bar',
            data: chartData,
            options: chartOptions
        });
    }
}
</script>

