<template>
    <div class="card">
        <div class="card-header">
            Step 2 - Normalisasi
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover">
                <thead class="table-info">
                    <tr>
                        <th class="text-center">Kriteria</th>
                        <th class="text-center" v-for="item in criterias" :key="item.id">{{ item.code }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="criteria in criterias" :key="criteria.id">
                        <th class="text-center table-info">{{ criteria.code }}</th>
                        <td class="text-center" v-for="comparison in criteria.comparisons" :key="comparison.id">{{ comparison.normalization_value }}</td>
                    </tr>
                    <tr>
                        <th class="text-center table-info">Jumlah</th>
                        <td class="text-center font-weight-bold table-light" v-for="item in total" :key="item.code">{{ item.total_normalization }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        criterias: Array,
        total: Array
    }
}
</script>
