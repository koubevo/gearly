<template>
    <button class="primary-button-style" type="{{ type }}">{{ text }}<slot /></button>
</template>

<script setup>

defineProps({
    text: String,
    type: String
})
</script>