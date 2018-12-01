<template>
    <button class="btn btn-info app-shadow" @click="click">
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
    },

    methods: {
        clicked() {}
    }
}
</script>

