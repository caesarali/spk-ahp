<template>
    <section class="content mt-3">
        <!-- <div class="container">
            <div class="card card-info">
                <div class="card-header d-flex text-center text-sm-left">
                    <a href="#" class="mr-3" @click.prevent="$router.go(-1)">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    Bobot Alternative dari sisi Kriteria
                    <a href="#" class="ml-auto d-none d-sm-inline-block">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
                <div class="card-body">
                    <canvas ref="myChart" style="min-height: 400px"></canvas>
                </div>
            </div>
        </div> -->
        <div class="container" v-if="showDetails">
            <step-1 :alternatives="alternatives" :total="matrixSumResult" />
            <step-2 :alternatives="alternatives" :total="matrixSumResult" />
            <step-3 :alternatives="alternatives" :total="matrixSumResult" />
            <step-4 :alternatives="alternatives" :total="matrixSumResult" :result="matrixMultiplicationResult" />
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
            showDetails: true,
            alternatives: [],
            matrixSumResult: [],
            matrixMultiplicationResult: [],
        }
    },
    computed: {
        criteriaId() {
            return this.$route.params.criteriaId
        }
    },
    methods: {
        init() {
            axios.get('/analysis/alternative/'+this.criteriaId+'/result')
            .then(({ data }) => {
                this.alternatives = data.data
                this.matrixSumResult = data.matrix_sum_result
                this.matrixMultiplicationResult = data.matrix_multiplication_result
            })
        },
    },
    created() {
        this.init()
    }
}
</script>
