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
                        Data Kriteria
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th width=10>#</th>
                                    <th>Kriteria</th>
                                    <th class="text-center">Code</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in data" :key="item.id">
                                    <td>{{ index+1 }}.</td>
                                    <td>{{ item.name }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-info">{{ item.code }}</span>
                                    </td>
                                    <td class="text-right" nowrap>
                                        <a href="#" @click.prevent="edit(item)" class="text-secondary mx-2">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="#" @click.prevent="destroy(item.id)" class="text-secondary mx-2">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <row-empty v-if="data.length == 0" cols="4" />
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <div id="criteriaModal" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Kriteria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? update() : store()">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Code</label>
                                <div class="col-md-9">
                                    <input v-model="form.code" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('code') }" name="code" placeholder="Kode Kriteria..">
                                    <has-error :form="form" field="code"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Name</label>
                                <div class="col-md-9">
                                    <input v-model="form.name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" name="name" placeholder="Nama Kriteria..">
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            keyword: '',
            criterias: [],
            form: new Form({
                id: '',
                code: '',
                name: '',
            })
        }
    },
    computed: {
        data() {
            return this.criterias.filter(criteria => {
                return criteria.name.toLowerCase().includes(this.keyword.toLowerCase())
            })
        }
    },
    methods: {
        init() {
            axios.get('/criterias')
            .then(({ data }) => { this.criterias = data.data })
        },
        create() {
            this.editmode = false;
            this.form.reset();
            this.form.clear();
            $('.modal').modal('show');
        },
        store() {
            this.form.post('/criterias')
            .then(({ data }) => {
                this.criterias.push(data.data)
                toast({type: 'success', text: data.message})
                $('#criteriaModal').modal('hide');
            })
            .catch()
        },
        edit(data) {
            this.editmode = true;
            this.form.reset();
            this.form.clear();
            this.form.fill(data);
            $('.modal').modal('show');
        },
        update() {
            this.form.patch('/criterias/' + this.form.id)
            .then(({ data }) => {
                this.init();
                toast({type: 'success', text: data.message});
                $('#criteriaModal').modal('hide');
            })
            .catch()
        },
        destroy(id) {
            this.$confirm.delete().then((result) => {
                if (result.value) {
                    this.form.delete('/criterias/' + id)
                    .then(({ data }) => {
                        toast({ type: 'success', title: data.message });
                        this.init();
                    })
                    .catch(() => {
                        toast({ type: 'error', title: 'Terjadi Kesalahan!' });
                    });
                }
            })
        }
    },

    created() {
        this.init()
    }
}
</script>
