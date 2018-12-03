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
                    <div class="row">
                        <div class="col-sm-3 mb-3">
                            <select class="form-control">
                                <option value="" disabled hidden selected>Pilih Kriteria</option>
                                <option v-for="item in criterias" :key="item.id" :value="item.id">{{ item.code }} - {{ item.name }}</option>
                            </select>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <select class="form-control">
                                <option value="" disabled hidden selected>Pilih Bobot</option>
                            </select>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <select class="form-control">
                                <option value="" disabled hidden selected>Pilih Kriteria</option>
                                <option v-for="item in criterias" :key="item.id" :value="item.id">{{ item.code }} - {{ item.name }}</option>
                            </select>
                        </div>
                    </div>
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
                            <tr v-for="item in criterias" :key="item.id">
                                <th class="text-center table-info">{{ item.code }}</th>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
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
            criterias: []
        }
    },

    methods: {
        init() {
            axios.get('/criterias').then(({ data }) => { this.criterias = data.data })
        }
    },

    created() {
        this.init()
    }
}
</script>
