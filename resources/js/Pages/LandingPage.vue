<template>
    <OffersSection :offers="newArrivals" :heading="'New arrivals'" :link="route('offer.index')"/>
</template>

<script setup>
import OffersSection from '@/Components/LandingPage/OffersSection.vue';

defineProps({
    newArrivals: {
        type: Array,
    },
});
</script>