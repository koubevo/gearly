<template>
    <!-- TODO: move to OffersGrid.vue -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8">
        <Card v-for="offer in offers" :key="offer.id">
        </Card>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import MainLayout from '@/Layouts/MainLayout.vue';
    import Card from '@/Components/Card.vue';

    defineOptions({ layout: MainLayout })

    defineProps({
        offers: Array,
    })
</script>