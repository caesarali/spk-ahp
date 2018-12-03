<template>
    <td :colspan="cols" nowrap class="text-center text-secondary">
        Data tidak ditemukan...
    </td>
</template>

<script>
export default {
    props: ['cols']
}
</script>