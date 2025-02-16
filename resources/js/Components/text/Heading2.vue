<template>
   <h2 class="heading2-style">{{ text }} <slot/></h2>
</template>

<script setup>
defineProps({
    text: String
})
</script>