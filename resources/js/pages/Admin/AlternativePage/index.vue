<template>
    <div>
        <section class="content-header">
            <div class="container-fluid">
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
                    <div class="col-auto">
                        <btn-default :click="create">
                            <i class="fas fa-plus"></i>
                        </btn-default>
                    </div>
                </div>
            </div>
        </section>

        <section class="content px-2">
            <div class="container-fluid">
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
                                    <th>Tarif</th>
                                    <th>Fasilitas</th>
                                    <th>Luas</th>
                                    <th>Parkiran</th>
                                    <th>Keamanan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="x in 5" :key="x">
                                    <td>{{ x }}</td>
                                    <td>Sampel Wisma {{ x }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-info">Alt{{ x }}</span>
                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td class="text-right" nowrap>
                                        <a href="#" class="text-secondary mx-2">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="#" class="text-secondary mx-2">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" role="dialog" aria-hidden="true">
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
                        <div class="bg-light px-3 py-4">
                            <h5 class="mb-0">Kriteria Alternatif / Wisma</h5>
                        </div>
                        <div class="modal-body pb-0">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tarif</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Tarif sewa kamar..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Fasilitas</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Fasilitas kamar..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Luas (m)</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Luas kamar..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Parkiran</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Daya tampung parkiran..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" style="white-space: nowrap">Pos Keamanan</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Jumlah pos keamanan..">
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
            form: new Form({
                code: '',
                name: '',
            })
        }
    },
    computed: {
        data() {
            // return this.users.filter(user => {
            //     return user.name.toLowerCase().includes(this.keyword.toLowerCase())
            // })
        }
    },
    methods: {
        create() {
            this.editmode = false;
            this.form.reset();
            this.form.clear();
            $('.modal').modal('show');
        },
        store() {

        },
        edit(data) {

        },
        update() {

        },
        destroy(id) {

        }
    }
}
</script>
