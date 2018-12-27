<template>
    <section class="content mt-3">
        <div class="container">
            <div class="card card-info">
                <div class="card-header text-center text-sm-left">
                    <b><u>Hasil Analisa Terakhir</u></b> <span class="ml-1 d-none d-sm-inline">Berdasarkan dari kriteria masing-masing Alternatif</span>
                </div>
                <div class="card-body">
                    <canvas nowrap ref="myChart" style="min-height: 300px"></canvas>
                </div>
            </div>
            <div class="card-group">
                <div class="card card-info d-none d-sm-flex">
                    <div class="card-header text-center">
                        <b>Detail</b>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr v-for="item in criterias" :key="item.id">
                                <td>{{ item.name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card card-info" v-for="item in alternatives" :key="item.id">
                    <div class="card-header text-center">
                        <b style="white-space: nowrap">{{ item.name }}</b>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr v-for="detail in item.detail" :key="detail.criteria_id">
                                <td class="text-center">{{ detail.value }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            result: [],
            criterias: [],
            alternatives: [],
            colors: ['rgba(190, 229, 235, 0.7)', 'rgba(176, 221, 153, 0.7)', 'rgba(226, 193, 192, 0.7)']
        }
    },
    watch: {
        'result': function() {
            this.chart()
        }
    },
    computed: {
        chartLabels() {
            return this.criterias.map(item => {
                return item.code + ' - ' + item.name
            })
        },
        charDatasets() {
            return this.result.map((item, index) => {
                return {
                    label : item.name,
                    borderColor : this.colors[index],
                    backgroundColor : this.colors[index],
                    data : item.criteria_priorities.map(pv => {
                        return pv.value
                    })
                }
            })
        }
    },
    methods: {
        init() {
            axios.get('/analysis/result/by-alternative')
            .then(({ data }) => {
                this.result = data.data
                this.criterias = data.criterias
                this.alternatives = data.alternatives
            })
        },
        chart() {
            let labels = this.chartLabels;
            let value = this.chartValue;
            let datasets = this.charDatasets;
            let chartData = {
                labels  : labels,
                datasets: datasets
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
    },
    created() {
        this.init()
    }
}
</script>
