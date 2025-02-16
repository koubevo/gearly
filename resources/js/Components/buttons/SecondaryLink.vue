<template>
    <Link class="secondary-button-style">{{ text }}<slot /></Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    text: String
})
</script>