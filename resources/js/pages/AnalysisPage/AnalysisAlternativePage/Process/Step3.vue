<template>
    <div class="card">
        <div class="card-header">
            Step 3 - Priority Vector
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover">
                <thead class="table-info">
                    <tr>
                        <th class="text-center">Kriteria</th>
                        <th class="text-center" v-for="item in criterias" :key="item.id">{{ item.code }}</th>
                        <th class="text-center">PV</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="criteria in criterias" :key="criteria.id">
                        <th class="text-center table-info">{{ criteria.code }}</th>
                        <td class="text-center" v-for="comparison in criteria.comparisons" :key="comparison.id">{{ comparison.normalization_value }}</td>
                        <td class="text-center bg-light font-weight-bold">{{ criteria.pv }}</td>
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
