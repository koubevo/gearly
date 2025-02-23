<template>
    <OffersSection :offers="newArrivals" :heading="'New Arrivals'" :link="route('offer.index')"/>
    
    <OffersSection :offers="brandWithMostActiveOffers" :heading="'New Arrivals from ' + brandWithMostActiveOffers[0].brand.name" :link="route('offer.index', {brand: brandWithMostActiveOffers[0].brand_id})"/>
    <!-- TODO: recently viewed, in your wishlist, top in mlb merch, for loop (lazy loading), most liked, most viewed -> trendy, every category (foreach) -->

    <OffersSection :offers="baseballBats" :heading="'Baseball Bats'" :link="route('offer.index', {category: 1, sport: 2})"/>

    <OffersSection :offers="softballBats" :heading="'Softball Bats'" :link="route('offer.index', {category: 1, sport: 3})"/>

    <OffersSection :offers="baseballGear" :heading="'Baseball Gear'" :link="route('offer.index', {sport: 2})"/>

    <OffersSection :offers="softballGear" :heading="'Softball Gear'" :link="route('offer.index', {sport: 3})"/>
</template>

<script setup>
import OffersSection from '@/Components/LandingPage/OffersSection.vue';

defineProps({
    newArrivals: Array,
    brandWithMostActiveOffers: Array,
    baseballBats: Array ?? [],
    softballBats: Array ?? [],
    baseballGear: Array ?? [],
    softballGear: Array ?? [],
});
</script>