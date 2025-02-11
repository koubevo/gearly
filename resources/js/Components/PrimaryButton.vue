<template>
    <Link class="primary-button-style">{{ text }}</Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    text: String
})
</script>