<template>
    <Head :title="'Home'" />
    <OffersSection :offers="newArrivals" :heading="'New Arrivals'" :link="route('offer.index')"/>
    
    <OffersSection v-if="brandWithMostActiveOffers.length > 2" :offers="brandWithMostActiveOffers" :heading="'New Arrivals from ' + brandWithMostActiveOffers[0]?.brand.name" :link="route('offer.index', {brand: brandWithMostActiveOffers[0].brand_id})"/>
    <!-- TODO: recently viewed, in your wishlist, top in mlb merch, for loop (lazy loading), most liked, most viewed -> trendy, every category (foreach), already using -->
    <!-- favorite brands ... 4 velky obdelniky s napisem znacka (count) -->

    <OffersSection v-if="baseballBats.length > 2" :offers="baseballBats" :heading="'Baseball Bats'" :link="route('offer.index', {category: 1, sport: 2})"/>

    <OffersSection v-if="softballBats.length > 2" :offers="softballBats" :heading="'Softball Bats'" :link="route('offer.index', {category: 1, sport: 3})"/>

    <OffersSection v-if="baseballGear.length > 2" :offers="baseballGear" :heading="'Baseball Gear'" :link="route('offer.index', {sport: 2})"/>

    <OffersSection v-if="softballGear.length > 2" :offers="softballGear" :heading="'Softball Gear'" :link="route('offer.index', {sport: 3})"/>
</template>

<script setup>
import OffersSection from '@/Components/LandingPage/OffersSection.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    newArrivals: Array,
    brandWithMostActiveOffers: Array ?? [],
    baseballBats: Array ?? [],
    softballBats: Array ?? [],
    baseballGear: Array ?? [],
    softballGear: Array ?? [],
});
</script>