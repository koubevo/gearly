<template>
    <OffersGrid :offers="offers"/>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import MainLayout from '@/Layouts/MainLayout.vue';
    import OffersGrid from '@/Components/Offer/OffersGrid.vue';

    defineOptions({ layout: MainLayout })

    defineProps({
        offers: Array,
    })
</script>