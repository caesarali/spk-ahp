<template>
    <section class="content mt-3">
        <div class="container">
            <div class="card">
                <div class="card-header d-flex text-center text-sm-left">
                    Mari, mulai analisis kriteria !
                    <a href="#" class="text-secondary ml-auto">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
                <div class="card-body pb-1">
                    <form class="row" @submit.prevent="setValue">
                        <div class="col-sm-3 mb-3">
                            <select v-model="form.first_criteria_id" :class="{ 'is-invalid': form.errors.has('first_criteria_id') }" class="form-control">
                                <option value="" disabled hidden selected>Pilih Kriteria</option>
                                <option v-for="item in criterias" :key="item.id" :value="item.id">{{ item.code }} - {{ item.name }}</option>
                            </select>
                            <has-error :form="form" field="first_criteria_id"></has-error>
                        </div>
                        <div class="col-sm mb-3">
                            <select v-model="form.value" :class="{ 'is-invalid': form.errors.has('value') }" class="form-control">
                                <option value="" disabled hidden selected>Pilih Bobot</option>
                                <option v-for="item in scales" :key="item.id" :value="item.value">{{ item.value }} - {{ item.caption }}</option>
                            </select>
                            <has-error :form="form" field="value"></has-error>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <select v-model="form.second_criteria_id" :class="{ 'is-invalid': form.errors.has('second_criteria_id') }" class="form-control">
                                <option value="" disabled hidden selected>Pilih Kriteria</option>
                                <option v-for="item in criterias" :key="item.id" :value="item.id">{{ item.code }} - {{ item.name }}</option>
                            </select>
                            <has-error :form="form" field="second_criteria_id"></has-error>
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
                                <th class="text-center">Kriteria</th>
                                <th class="text-center" v-for="item in criterias" :key="item.id">{{ item.code }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="first in criterias" :key="first.id">
                                <th class="text-center table-info">{{ first.code }}</th>
                                <td class="text-center matrix-value" v-for="second in criterias" :key="second.id" style="cursor:pointer" @click="editValue(first.id, second.id)">
                                    {{ getValue(first.id, second.id) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <btn-default class="ml-auto btn-block-xs" :click="analysis">
                        Mulai Analisa <i class="fas ml-1" :class="[analiting ? 'fa-spinner fa-spin' : 'fa-chevron-circle-right']"></i>
                    </btn-default>
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
            criterias: [],
            matrix: [],
            form: new Form({
                first_criteria_id: '',
                second_criteria_id: '',
                value: '',
            })
        }
    },

    methods: {
        init() {
            axios.all([this.getScales(), this.getCriteria(), this.getCriteriaMatrix()])
        },
        getScales() {
            return axios.get('/rating-scales').then(({ data }) => { this.scales = data.data })
        },
        getCriteria() {
            return axios.get('/criterias').then(({ data }) => { this.criterias = data.data })
        },
        getCriteriaMatrix() {
            return axios.get('/analysis/criteria').then(({ data }) => { this.matrix = data.data })
        },
        getValue(row, col) {
            let data = this.matrix.filter(item => {
                return item.first_criteria_id == row && item.second_criteria_id == col
            })
            return data.length ? data[0].value : null;
            // if (!data.length) {
            //     let invers = this.matrix.filter(item => {
            //         return item.first_criteria_id == col && item.second_criteria_id == row
            //     })
            //     return invers.length ? '1/' + invers[0].value : '-';
            // } else {
            //     return data[0].value
            // }
        },
        setValue() {
            this.form.post('/analysis/criteria')
            .then(({ data }) => {
                this.form.reset();
                this.form.clear();
                this.getCriteriaMatrix()
                toast({type: 'success', text: data.message})
            })
        },
        editValue(first, second) {
            this.form.first_criteria_id = first
            this.form.second_criteria_id = second
            let value = this.getValue(first, second)
            if (value >= 1) {
                this.form.value = this.getValue(first, second)
            } else {
                this.form.value = ''
            }
        },
        analysis() {
            this.analiting = true;
            axios.post('/analysis/criteria/result')
            .then(() => this.$router.push({ name: 'analysis.criteria.result' }))
        }
    },

    created() {
        this.init()
    }
}
</script>

<style lang="scss" scoped>
    .matrix-value:hover {
        background-color: #bee5eb;
    }
</style>
