<template>
    <OffersSection :offers="newArrivals" :heading="'New arrivals'" :link="route('offer.index')"/>
    
    <OffersSection :offers="brandWithMostActiveOffers" :heading="'New arrivals from ' + brandWithMostActiveOffers[0].brand.name" :link="route('offer.index', {brand: brandWithMostActiveOffers[0].brand_id})"/>
    <!-- TODO: recently viewed, in your wishlist -->
</template>

<script setup>
import OffersSection from '@/Components/LandingPage/OffersSection.vue';

defineProps({
    newArrivals: Array,
    brandWithMostActiveOffers: Array

});
</script>