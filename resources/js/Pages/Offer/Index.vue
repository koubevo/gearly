<template>
    <OffersGrid :offers="offers"/>
</template>

<script setup>
    import MainLayout from '@/Layouts/MainLayout.vue';
    import OffersGrid from '@/Components/Offer/OffersGrid.vue';

    defineOptions({ layout: MainLayout })

    defineProps({
        offers: Object,
    })
</script>