<template>
    <Link class="bg-white border-2 border-black border-solid py-2 text-black hover:border-b-4 font-medium w-full text-center">{{ text }}</Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    text: String
})
</script>