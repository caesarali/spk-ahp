<template>
    <div>
        <section class="content-header">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="form-inline">
                            <div class="input-group app-shadow">
                                <input v-model="keyword" type="search" placeholder="Search" aria-label="Search" class="form-control form-control-navbar border-0">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-white border-0">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto d-none d-sm-block">
                        <btn-default :click="create">
                            <i class="fas fa-plus"></i>
                        </btn-default>
                    </div>
                </div>
            </div>
        </section>

        <btn-fly :click="create">
            <i class="fas fa-plus"></i>
        </btn-fly>

        <section class="content px-2">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        Data Alternatif
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th width=10>#</th>
                                    <th>Name</th>
                                    <th class="text-center">Code</th>
                                    <th v-for="item in criterias" :key="item.id" class="text-center">{{ item.name }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(alternative, index) in data" :key="alternative.id">
                                    <td>{{ index+1 }}.</td>
                                    <td nowrap>{{ alternative.name }}</td>
                                    <td nowrap class="text-center">
                                        <span class="badge badge-info">{{ alternative.code }}</span>
                                    </td>
                                    <td nowrap v-for="criteria in criterias" :key="criteria.id" class="text-center">
                                        <a href="#" v-if="showDetail(alternative, criteria)" @click.prevent="editDetail(alternative, criteria)" class="text-body">
                                            {{ showDetail(alternative, criteria) }}
                                        </a>
                                        <a href="#" v-else @click.prevent="newDetail(alternative, criteria)" class="text-body">
                                            +
                                        </a>
                                    </td>
                                    <td class="text-right" nowrap>
                                        <a href="#" @click.prevent="edit(alternative)" class="text-secondary mx-2">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="#" @click.prevent="destroy(alternative.id)" class="text-secondary mx-2">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <row-empty v-if="data.length == 0" :cols="4 + criterias.length" />
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <div id="alternativeModal" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Alternatif / Wisma</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? update() : store()">
                        <div class="modal-body pb-0">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Code</label>
                                <div class="col-md-9">
                                    <input v-model="form.code" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('code') }" name="code" placeholder="Kode Alternatif..">
                                    <has-error :form="form" field="code"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Name</label>
                                <div class="col-md-9">
                                    <input v-model="form.name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" name="name" placeholder="Nama Alternatif..">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <btn-default type="submit" :disabled="form.busy">
                                <i class="fas mr-1" :class="[form.busy ? 'fa-spinner fa-spin' : 'fa-check']"></i> Simpan
                            </btn-default>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="alternativeDetail" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ detail.alternative_name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="addDetail">
                        <div class="modal-body pb-0">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ detail.criteria_name }}</label>
                                <div class="col-md-9">
                                    <input v-model="detail.value" type="text" class="form-control" :class="{ 'is-invalid': detail.errors.has('value') }" name="value" placeholder="...">
                                    <has-error :form="detail" field="value"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <btn-default type="submit" :disabled="detail.busy">
                                <i class="fas mr-1" :class="[detail.busy ? 'fa-spinner fa-spin' : 'fa-check']"></i> Simpan
                            </btn-default>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            keyword: '',
            criterias: [],
            alternatives: [],
            alternativeDetail: [],
            form: new Form({
                id: '',
                code: '',
                name: ''
            }),
            detail: new Form({
                alternative_id: '',
                alternative_name: '',
                criteria_id: '',
                criteria_name: '',
                value: '',
            })
        }
    },
    computed: {
        data() {
            return this.alternatives.filter(alternative => {
                return alternative.name.toLowerCase().includes(this.keyword.toLowerCase())
            })
        }
    },
    methods: {
        init() {
            axios.all([this.getCriteria(), this.getAlternative(), this.getAlternativeDetail()])
        },
        getCriteria() {
            return axios.get('/criterias').then(({ data }) => { this.criterias = data.data })
        },
        getAlternative() {
            return axios.get('/alternatives').then(({ data }) => { this.alternatives = data.data })
        },
        getAlternativeDetail() {
            return axios.get('/alternative/detail').then(({ data }) => { this.alternativeDetail = data.data })
        },
        create() {
            this.editmode = false;
            this.form.reset();
            this.form.clear();
            $('#alternativeModal').modal('show');
        },
        store() {
            this.form.post('/alternatives')
            .then(({ data }) => {
                this.alternatives.push(data.data)
                toast({ type: 'success', text: data.message })
                $('#alternativeModal').modal('hide');
            })
            .catch(() => {})
        },
        edit(data) {
            this.editmode = true;
            this.form.reset();
            this.form.clear();
            this.form.fill(data);
            $('#alternativeModal').modal('show');
        },
        update() {
            this.form.patch('/alternatives/' + this.form.id)
            .then(({ data }) => {
                this.getAlternative();
                toast({type: 'success', text: data.message});
                $('#alternativeModal').modal('hide');
            })
            .catch(() => {})
        },
        destroy(id) {
            this.$confirm.delete().then((result) => {
                if (result.value) {
                    this.form.delete('/alternatives/' + id)
                    .then(({ data }) => {
                        toast({ type: 'success', title: data.message });
                        this.getAlternative();
                    })
                    .catch(() => {
                        toast({ type: 'error', title: 'Terjadi Kesalahan!' });
                    });
                }
            })
        },

        showDetail(alternative, criteria) {
            let detail = this.alternativeDetail.filter(item => {
                return item.alternative_id == alternative.id && item.criteria_id == criteria.id
            })

            return detail.length ? detail[0].value : null;
        },
        newDetail(alternative, criteria) {
            this.detail.reset();
            this.detail.clear();
            this.detail.alternative_id = alternative.id,
            this.detail.alternative_name = alternative.name,
            this.detail.criteria_id = criteria.id,
            this.detail.criteria_name = criteria.name

            $('#alternativeDetail').modal('show');
        },
        editDetail(alternative, criteria) {
            this.detail.reset();
            this.detail.clear();
            let data = this.alternativeDetail.filter(item => {
                return item.alternative_id == alternative.id && item.criteria_id == criteria.id
            })
            this.detail.fill(data[0]);

            $('#alternativeDetail').modal('show');
        },
        addDetail() {
            this.detail.post('/alternative/detail')
            .then(({ data }) => {
                this.alternativeDetail = data.data
                $('.modal').modal('hide')
            })
        }
    },

    created() {
        this.init()
    }
}
</script>
