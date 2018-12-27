<template>
    <section class="content mt-3">
        <div class="container">
            <div class="card card-info">
                <div class="card-header d-flex text-center text-sm-left">
                    Hasil / Kesimpulan Akhir
                    <a href="#" class="ml-auto d-none d-sm-inline-block" @click.prevent="view == 'table' ? view='chart' : view='table' ">
                        <i class="fas" :class="view == 'table' ? 'fa-chart-bar' : 'fa-table'"></i>
                    </a>
                </div>
                <div class="card-body p-0 table-responsive" v-show="view == 'table'">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th nowrap class="text-center" v-for="item in criterias" :key="item.id">{{ item.name }}</th>
                                <th nowrap class="text-center table-secondary">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in alternatives" :key="item.id" :class="{ 'table-info': item.total == topPoint }">
                                <td nowrap><b>{{ item.code + ' : ' +item.name }}</b></td>
                                <td class="text-center" v-for="pv in item.priorities" :key="pv.id">{{ pv.value }}</td>
                                <td class="text-center table-secondary" :class="{ 'font-weight-bold table-info': item.total == topPoint }">{{ item.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body" v-show="view == 'chart'">
                    <canvas ref="myChart" style="min-height: 400px"></canvas>
                </div>
                <div class="card-footer text-center py-4">
                    <b>Kesimpulan</b> : Jadi, wisma yang disarankan oleh system adalah <b v-for="item in result" :key="item.id"><u>"{{ item.name }}"</u></b>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { Chart } from "chart.js";
export default {
    data() {
        return {
            view: 'table',
            alternatives: [],
            criterias: []
        }
    },
    watch: {
        'alternatives': function (value) {
            this.chart()
        }
    },
    computed: {
        points() {
            return this.alternatives.map(item => {
                return item.total
            })
        },
        topPoint() {
            return this.points.sort(function (a, b) {
                return b-a
            })[0]
        },
        result() {
            return this.alternatives.filter(item => {
                return item.total == this.topPoint
            })
        },
        chartLabels() {
            return this.alternatives.map(item => {
                return item.code + ' - ' + item.name
            })
        },
        chartValue() {
            return this.alternatives.map(item => {
                return item.total
            })
        }
    },
    methods: {
        init() {
            axios.get('/analysis/result')
            .then(({ data }) => {
                this.alternatives = data.data
                this.criterias = data.criterias
            })
        },
        chart() {
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
    },
    created() {
        this.init()
    }
}
</script>
