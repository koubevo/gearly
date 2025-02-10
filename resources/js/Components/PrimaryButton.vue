<template>
    <Link class="bg-primary-900 border-2 border-black border-solid px-6 py-2 text-white hover:border-b-4 font-medium w-full text-center">{{ text }}</Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    text: String
})
</script>