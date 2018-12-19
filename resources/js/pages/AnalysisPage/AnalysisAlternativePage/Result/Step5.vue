<template>
    <div class="card">
        <div class="card-header border-0">
            Step 5 - Pengujian Konsistensi
        </div>
        <div class="p-3 bg-light">
            Perhitungan Weight Sum Vector <b>( λ maksimum )</b>
        </div>
        <div class="card-body">
            <p>
                <span class="font-weight-bold">λmax = ( Hasil kali matriks / PV ) / n </span>
            </p>
            <p>
                <span class="font-weight-bold">λmax = </span>
                <span v-for="(item, index) in alternatives" :key="item.id">({{ result[index] }} / {{ item.pv }}) <span v-if="index < alternatives.length - 1"> + </span> </span> / {{ alternatives.length }}
            </p>
            <p>
                <span class="font-weight-bold">λmax = </span>
                <span v-for="(item, index) in lambda" :key="index">{{ item }} <span v-if="index < lambda.length - 1"> + </span> </span> / {{ alternatives.length }}
            </p>
            <p>
                <span class="font-weight-bold">λmax = </span>
                {{ lambdaTotal }} / {{ alternatives.length }} = <b><u>{{ lambdaMax }}</u></b>
            </p>
        </div>
        <div class="p-3 bg-light">
            Perhitungan Consistency Index <b>( CI )</b>
        </div>
        <div class="card-body">
            <p>
                <span class="font-weight-bold">CI = (λmax - n) / (n - 1) </span>
            </p>
            <p>
                <span class="font-weight-bold">CI = </span>
                ({{ lambdaMax }} - {{ alternatives.length }}) / ({{ alternatives.length }} - 1)
            </p>
            <p>
                <span class="font-weight-bold">CI = </span>
                <u><b>{{ ci }}</b></u>
            </p>
        </div>
        <div class="p-3 bg-light">
            Tabel Index Random <b>( IR )</b>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <tbody>
                    <tr>
                        <td class="table-info text-center font-weight-bold">n</td>
                        <td class="text-center" :class="{ 'table-secondary font-weight-bold': item.n == ir.n }" v-for="item in indexRandom" :key="item.n">{{ item.n }}</td>
                    </tr>
                    <tr>
                        <td class="table-info text-center font-weight-bold">IR</td>
                        <td class="text-center" :class="{ 'table-secondary  font-weight-bold': item.ir == ir.value }" v-for="item in indexRandom" :key="item.n">{{ item.ir }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-3 bg-light">
            Perhitungan Consistency Ratio <b>( CR )</b>
        </div>
        <div class="card-body">
            <p>
                <span class="font-weight-bold">CR = CI / IR </span>
            </p>
            <p>
                <span class="font-weight-bold">CR = </span>
                {{ ci }} / {{ ir.value }}
            </p>
            <p>
                <span class="font-weight-bold">CR = </span>
                 <u><b>{{ cr }}</b></u>
            </p>
            <p>
                <span class="font-weight-bold">CR = </span>
                 <b>{{ cr }} <span v-html="'<'"></span> 0.1 <span v-html="consistency"></span></b>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        alternatives: Array,
        result: Array,
        indexRandom: Array
    },
    computed: {
        lambda: function() {
            return this.alternatives.map((item, index) => {
                let lambda = this.result[index] / item.pv
                return parseFloat(lambda.toFixed(5))
            })
        },
        lambdaTotal: function () {
            return this.lambda.reduce((a, b) => a + b, 0)
        },
        lambdaMax: function() {
            return (this.lambdaTotal / this.alternatives.length).toFixed(5)
        },
        ci: function () {
            return (this.lambdaMax - this.alternatives.length).toFixed(5) / (this.alternatives.length - 1)
        },
        ir: function () {
            let index = this.indexRandom.filter(item => {
                return item.n == this.alternatives.length
            })

            return index.map(item => {
                return {
                    n: item.n,
                    value: item.ir
                }
            })[0]

        },
        cr: function () {
            return this.ci / this.ir.value;
        },
        consistency: function() {
            return (this.cr <= 0.1) ? '<u class="text-success">(KONSISTEN)</u>' : '<u class="text-danger">(TIDAK KONSISTEN)</u>'
        }
    }
}
</script>
