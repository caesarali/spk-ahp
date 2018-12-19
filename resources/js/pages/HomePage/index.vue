<template>
    <section class="content mt-3">
        <div class="container">
            <div class="card card-info">
                <div class="card-header d-flex text-center text-sm-left">
                    Analisa Terakhir
                </div>
                <div class="card-body">
                    <chart-bar :chartLabels="chartLabels" :chartValue="chartValue" v-if="chartLabels.length > 0" />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            alternatives: [],
            criterias: []
        }
    },
    computed: {
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
        }
    },
    created() {
        this.init()
    }
}
</script>
