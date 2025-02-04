<template>
    <div v-if="flashSuccess" class="message-success">
        {{ flashSuccess }}
    </div>
    <slot></slot>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const flashSuccess = computed(() => page.props.flash?.success ?? '');
</script>

<style scoped>
    .message-success {
        background-color: green;
        color: white;
    }
</style>