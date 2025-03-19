<template>
   <h1 class="heading1-style">{{ text }} <slot/></h1>
</template>

<script setup>
defineProps({
    text: String
})
</script>