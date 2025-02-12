<template>
    <button class="secondary-button-style" type="{{ type }}">{{ text }}<slot /></button>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    text: String,
    type: String
})
</script>