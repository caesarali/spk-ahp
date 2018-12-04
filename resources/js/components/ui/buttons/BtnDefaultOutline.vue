<template>
    <button class="btn btn-outline-info" @click="click">
        <slot>Button Default</slot>
    </button>
</template>

<script>
export default {
    props: {
        click: {
            required: false,
            type: Function,
            default: function() {

            }
        }
    }
}
</script>

