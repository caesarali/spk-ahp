<template>
    <!-- <i class="fas fa-check mr-1"></i> -->
    <i class="fas mr-1" :class="[busy ? 'fa-spinner fa-spin' : 'fa-check']"></i>
</template>

<script>
export default {
    props: {

        busy: {
            type: Boolean,
            required: false,
            default: false
        }
    }
}
</script>
