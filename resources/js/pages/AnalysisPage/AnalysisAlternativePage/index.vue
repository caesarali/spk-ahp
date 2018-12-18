<template>
    <section class="content mt-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header border-0 text-center text-sm-left">
                            Pilih Kriteria
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover">
                                <tbody>
                                    <tr v-for="item in criterias" :key="item.id" :class="[selectedCriteria.id == item.id ? 'bg-info' : 'pointer']" @click="selectedCriteria = item">
                                        <td>{{ item.name }}</td>
                                        <td class="text-right">
                                            <i class="fas fa-angle-double-right"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header text-center text-sm-left">
                            Perbandingan Alternatif Berdasarkan <b>"{{ selectedCriteria.name }}"</b>
                        </div>
                        <div class="card-body pb-1">
                            <form class="row" @submit.prevent="setValue">
                                <div class="col-sm-3 mb-3">
                                    <select v-model="form.x_alternative_id" :class="{ 'is-invalid': form.errors.has('x_alternative_id') }" class="form-control">
                                        <option value="" disabled hidden selected>Pilih Alternatif</option>
                                        <option v-for="item in alternatives" :key="item.id" :value="item.id">{{ item.code }}: {{ item.name }}</option>
                                    </select>
                                    <has-error :form="form" field="x_alternative_id"></has-error>
                                </div>
                                <div class="col-sm mb-3">
                                    <select v-model="form.value" :class="{ 'is-invalid': form.errors.has('value') }" class="form-control">
                                        <option value="" disabled hidden selected>Pilih Bobot</option>
                                        <option v-for="item in scales" :key="item.id" :value="item.value">{{ item.value }} - {{ item.caption }}</option>
                                    </select>
                                    <has-error :form="form" field="value"></has-error>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <select v-model="form.y_alternative_id" :class="{ 'is-invalid': form.errors.has('y_alternative_id') }" class="form-control">
                                        <option value="" disabled hidden selected>Pilih Alternatif</option>
                                        <option v-for="item in alternatives" :key="item.id" :value="item.id">{{ item.code }}: {{ item.name }}</option>
                                    </select>
                                    <has-error :form="form" field="y_alternative_id"></has-error>
                                </div>
                                <div class="col-sm-auto mb-3">
                                    <btn-default type="submit" class="btn-block-xs">
                                        <i class="fas fa-check"></i> <span class="d-inline d-sm-none ml-1">Update</span>
                                    </btn-default>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive card-body p-0">
                            <table class="table">
                                <thead class="table-info">
                                    <tr>
                                        <td class="text-center font-weight-bold">Alternatif</td>
                                        <th class="text-center" v-for="item in alternatives" :key="item.id">{{ item.code }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="x in alternatives" :key="x.id">
                                        <th class="text-center table-info">{{ x.code }}</th>
                                        <td class="text-center matrix-value pointer" v-for="y in alternatives" :key="y.id" @click="editValue(x.id, y.id)">
                                            {{ getValue(x.id, y.id) ? getValue(x.id, y.id) : '-' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body pb-0 border-top">
                            <h5 class="lead">Keterangan <span class="float-right">{{ selectedCriteria.name }}</span></h5>
                            <hr class="border m-0 mb-1">
                            <p v-for="item in alternativeDetail" :key="item.id">
                                <span class="badge badge-info">{{ item.code }}</span> : {{ item.name }}
                                <span class="float-right" v-for="detail in item.detail" :key="detail.id">{{ detail.value }}</span>
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <btn-default class="ml-auto btn-block-xs" :click="analyze">
                                Lihat Analisa <i class="fas ml-1" :class="[analiting ? 'fa-spinner fa-spin' : 'fa-chevron-circle-right']"></i>
                            </btn-default>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            analiting: false,
            scales: [],
            comparisons: [],
            alternatives: [],
            criterias: [],
            selectedCriteria: '',
            form: new Form({
                id: '',
                criteria_id: '',
                x_alternative_id: '',
                y_alternative_id: '',
                value: '',
            })
        }
    },
    computed: {
        alternativeDetail() {
            return this.alternatives.map(item => {
                return {
                    id: item.id,
                    code: item.code,
                    name: item.name,
                    detail: item.detail.filter(data => {
                                return data.criteria_id == this.selectedCriteria.id
                            })
                }
            })
        },
        alternativeComparison() {
            return this.comparisons.filter(item => {
                return item.criteria_id == this.selectedCriteria.id
            })
        }
    },
    watch: {
        selectedCriteria: function(value) {
            this.form.criteria_id = value.id
        }
    },
    methods: {
        init() {
            axios.all([this.getScales(), this.getAlternative(), this.getCriteria(), this.getComparison()])
        },
        getScales() {
            axios.get('/rating-scales').then(({ data }) => { this.scales = data.data })
        },
        getAlternative() {
            axios.get('/alternatives').then(({ data }) => { this.alternatives = data.data })
        },
        getCriteria() {
            axios.get('/criterias').then(({ data }) => { this.criterias = data.data, this.selectedCriteria = data.data[0] })
        },
        getComparison() {
            axios.get('/analysis/alternative').then(({ data }) => { this.comparisons = data.data })
        },

        getValue(x, y) {
            let data = this.alternativeComparison.filter(item => {
                return item.x_alternative_id == x && item.y_alternative_id == y
            })
            return data.length ? data[0].value : null;
        },
        editValue(x, y) {
            this.form.x_alternative_id = x
            this.form.y_alternative_id = y
            let value = this.getValue(x, y)
            if (value >= 1) {
                this.form.value = this.getValue(x, y)
            } else {
                this.form.value = ''
            }
        },
        setValue() {
            this.form.post('/analysis/alternative')
            .then(({ data }) => {
                this.form.reset()
                this.form.clear()
                this.form.criteria_id = this.selectedCriteria.id
                this.getComparison()
                toast({type: 'success', text: data.message})
            })
        },
        analyze() {
            this.analiting = true;
            axios.post('/analysis/alternative/' + this.selectedCriteria.id)
            .then(() => this.$router.push({ name: 'analysis.alternative.byCriteria', params: { criteriaId: this.selectedCriteria.id } }))
            .catch(({ response }) => toast({type: 'error', text: response.data}))
            .then(() => this.analiting = false)
        }
    },
    created() {
        this.init()
    }
}
</script>

<style lang="scss" scoped>
    .pointer {
        cursor: pointer;
    }

    .matrix-value:hover {
        background-color: #bee5eb;
    }
</style>
