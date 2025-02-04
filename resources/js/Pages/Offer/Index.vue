<template>
    <div v-for="offer in offers" :key="offer.id">
        <Link :href="`/offer/${offer.id}`">{{ offer.name }}</Link>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import MainLayout from '@/Layouts/MainLayout.vue';

    defineOptions({ layout: MainLayout })

    defineProps({
        offers: Array,
    })
</script>