<template>
    <Head class="capitalize" :title="$t('common.offers')" />
    <OffersGrid :offers="offers" :categories :brands :sports :conditions :filters/>
</template>

<script setup>
    import MainLayout from '@/Layouts/MainLayout.vue';
    import OffersGrid from '@/Components/Offer/OffersGrid.vue';
    import { Head } from '@inertiajs/vue3';

    defineOptions({ layout: MainLayout })

    const props = defineProps({
        offers: Object,
        categories: Array,
        brands: Array,
        sports: Array,
        conditions: Array,
        filters: Array,
    })
</script>