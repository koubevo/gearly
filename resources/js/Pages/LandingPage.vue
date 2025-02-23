<template>
    <OffersSection :offers="newArrivals" :heading="'New arrivals'" :link="route('offer.index')"/>
    
    <OffersSection :offers="brandWithMostActiveOffers" :heading="'New arrivals from ' + brandWithMostActiveOffers[0].brand.name" :link="route('offer.index', {brand: brandWithMostActiveOffers[0].brand_id})"/>
    <!-- TODO: recently viewed, in your wishlist, top in mlb merch, for loop (lazy loading) -->

    <OffersSection :offers="baseballBats" :heading="'Baseball bats'" :link="route('offer.index', {category: 1, sport: 2})"/>

    <OffersSection :offers="softballBats" :heading="'Softball bats'" :link="route('offer.index', {category: 1, sport: 3})"/>
</template>

<script setup>
import OffersSection from '@/Components/LandingPage/OffersSection.vue';

defineProps({
    newArrivals: Array,
    brandWithMostActiveOffers: Array,
    baseballBats: Array ?? [],
    softballBats: Array ?? [],
});
</script>