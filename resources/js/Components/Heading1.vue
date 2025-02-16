<template>
   <h1 class="font-semibold text-5xl mb-2">{{ text }} <slot/></h1>
</template>

<script setup>
defineProps({
    text: String
})
</script>