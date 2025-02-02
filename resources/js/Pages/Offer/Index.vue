<template>
    <div v-for="offer in offers" :key="offer.id">
        <Link :href="`/offer/${offer.id}`">{{ offer.name }}</Link>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    defineProps({
        offers: Array,
    })
</script>