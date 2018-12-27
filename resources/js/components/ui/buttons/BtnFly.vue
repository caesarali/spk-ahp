<template>
    <btn-default class="rounded-circle btn-fly d-block d-sm-none app-shadow" :click="click">
        <slot><i class="fas fa-plus"></i></slot>
    </btn-default>
</template>

<script>
export default {
    props: ['click']
}
</script>

<style>
    .btn-fly {
        position: fixed;
        bottom: 80px;
        right: 15px;
        height: 50px;
        width: 51px;
    }
</style>

