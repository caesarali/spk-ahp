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
                    <form class="row" @submit.prevent="store">
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
                                <option v-for="x in 9" :key="x" :value="x">{{ x }}</option>
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
                    <table class="table table-hover">
                        <thead class="table-info">
                            <tr>
                                <th class="text-center">Kriteria</th>
                                <th class="text-center" v-for="item in criterias" :key="item.id">{{ item.code }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="first in criterias" :key="first.id">
                                <th class="text-center table-info">{{ first.code }}</th>
                                <td class="text-center" v-for="second in criterias" :key="second.id">{{ getOrdoValue(first.id, second.id) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <btn-default class="ml-auto btn-block-xs">
                        Selanjutnya <i class="fas fa-chevron-circle-right ml-1"></i>
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
            axios.all([this.getCriteria(), this.getCriteriaMatrix()])
        },
        getCriteria() {
            axios.get('/criterias').then(({ data }) => { this.criterias = data.data })
        },
        getCriteriaMatrix() {
            axios.get('/analysis/criteria').then(({ data }) => { this.matrix = data.data })
        },
        getOrdoValue(row, col) {
            if (row == col) {
                return 1
            }
            let data = this.matrix.filter(item => {
                return item.first_criteria_id == row && item.second_criteria_id == col
            })
            if (!data.length) {
                let invers = this.matrix.filter(item => {
                    return item.first_criteria_id == col && item.second_criteria_id == row
                })
                return invers.length ? '1/' + invers[0].value : '-';
            } else {
                return data[0].value
            }
        },
        store() {
            this.form.post('/analysis/criteria')
            .then(() => {
                this.form.reset();
                this.form.clear();
                this.getCriteriaMatrix()
                toast({type: 'success', text: data.message})
            })
        }
    },

    created() {
        this.init()
    }
}
</script>
