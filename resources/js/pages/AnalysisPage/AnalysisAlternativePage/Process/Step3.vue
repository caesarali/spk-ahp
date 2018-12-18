<template>
    <div class="card">
        <div class="card-header">
            Step 3 - Priority Vector
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover">
                <thead class="table-info">
                    <tr>
                        <td class="text-center font-weight-bold">Alt<span class="d-none d-sm-inline">ernatif</span></td>
                        <th class="text-center" v-for="item in alternatives" :key="item.id">{{ item.code }}</th>
                        <th class="text-center">PV</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in alternatives" :key="item.id">
                        <th class="text-center table-info">{{ item.code }}</th>
                        <td class="text-center" v-for="comparison in item.comparisons" :key="comparison.id">{{ comparison.normalization_value }}</td>
                        <td class="text-center bg-light font-weight-bold">{{ item.pv }}</td>
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
        total: Array
    }
}
</script>
