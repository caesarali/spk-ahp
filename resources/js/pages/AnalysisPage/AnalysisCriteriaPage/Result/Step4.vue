<template>
    <div class="card">
        <div class="card-header">
            Step 4 - Perkalian Matriks
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr class="table-info">
                        <th class="text-center" :colspan="criterias.length">Matriks</th>
                        <td class="text-center" :rowspan="criterias.length + 1"></td>
                        <th class="text-center">PV</th>
                        <td class="text-center" :rowspan="criterias.length + 1"></td>
                        <th class="text-center">Hasil</th>
                    </tr>
                    <tr v-for="(criteria, index) in criterias" :key="criteria.id">
                        <td class="text-center" v-for="comparison in criteria.comparisons" :key="comparison.id">{{ comparison.value }}</td>
                        <td class="text-center">{{ criteria.pv }}</td>
                        <td class="text-center font-weight-bold">{{ result[index] }}</td>
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
        total: Array,
        result: Array
    }
}
</script>
