<template>
    <div class="card">
        <div class="card-header">
            Step 4 - Perkalian Matriks
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr class="table-info">
                        <th class="text-center" :colspan="alternatives.length">Matriks</th>
                        <td class="text-center" :rowspan="alternatives.length + 1" style="vertical-align: middle">
                            x
                        </td>
                        <th class="text-center">PV</th>
                        <td class="text-center" :rowspan="alternatives.length + 1" style="vertical-align: middle">
                            =
                        </td>
                        <th class="text-center">Hasil</th>
                    </tr>
                    <tr v-for="(item, index) in alternatives" :key="item.id">
                        <td class="text-center" v-for="comparison in item.comparisons" :key="comparison.id">{{ comparison.value }}</td>
                        <td class="text-center">{{ item.pv }}</td>
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
        alternatives: Array,
        total: Array,
        result: Array
    }
}
</script>
