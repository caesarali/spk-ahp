<template>
    <section class="content mt-3">
        <div class="container">
            <div class="card card-info">
                <div class="card-header d-flex text-center text-sm-left">
                    <link-back></link-back>
                    Bobot Prioritas Kriteria
                    <a href="#" class="ml-auto d-none d-sm-inline-block">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
                <div class="card-body">
                    <canvas ref="myChart" style="min-height: 400px"></canvas>
                </div>
            </div>
            <div class="card" style="cursor: pointer" @click="showDetails ? showDetails = false : showDetails = true">
                <div class="card-header border-0 d-flex">
                    <span class="mr-1" v-html="showDetails ? 'Sembunyikan' : 'Tampilkan'"></span> Operasi Perhitungan
                    <a href="#" class="ml-auto d-none d-sm-inline-block text-secondary">
                        <i class="fas" :class="showDetails ? 'fa-angle-up' : 'fa-angle-down'"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="container animated fadeIn" v-if="showDetails">
            <step-1 :criterias="criterias" :total="total" />
            <step-2 :criterias="criterias" :total="total" />
            <step-3 :criterias="criterias" :total="total" />
            <step-4 :criterias="criterias" :total="total" :result="result" />
            <step-5 :criterias="criterias" :result="result" :indexRandom="indexRandom" />
        </div>
    </section>
</template>

<script>
import Step1 from './Step1'
import Step2 from './Step2'
import Step3 from './Step3'
import Step4 from './Step4'
import Step5 from './Step5'
import { Chart } from "chart.js";
export default {
    components: {
        Step1, Step2, Step3, Step4, Step5
    },

    data() {
        return {
            showDetails: false,
            criterias: [],
            total: [],
            result: [],
            indexRandom: [],
        }
    },

    watch: {
        'criterias': function (value) {
            this.chart()
        }
    },

    computed: {
        chartLabels() {
            return this.criterias.map(item => {
                return item.code + ' - ' + item.name
            })
        },
        chartValue() {
            return this.criterias.map(item => {
                return item.pv
            })
        }
    },

    methods: {
        init() {
            axios.get('/analysis/criteria/result')
            .then(({ data }) => {
                this.criterias = data.data
                this.total = data.total
                this.result = data.result
                this.indexRandom = data.index_random
            })
        },
        chart() {
            let labels = this.chartLabels;
            let value = this.chartValue;
            let chartData = {
                labels  : labels,
                datasets: [
                    {
                        label : 'Kriteria',
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
