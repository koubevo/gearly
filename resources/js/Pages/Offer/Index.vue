<template>
    <Head class="capitalize" :title="$t('common.offers')" />
    <OffersGrid :offers="offers"/>
</template>

<script setup>
    import MainLayout from '@/Layouts/MainLayout.vue';
    import OffersGrid from '@/Components/Offer/OffersGrid.vue';
    import { Head } from '@inertiajs/vue3';

    defineOptions({ layout: MainLayout })

    defineProps({
        offers: Object,
    })
</script>