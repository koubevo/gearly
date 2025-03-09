<template>
    <Head :title="$t('landing.home')" />
    <OffersSection :offers="newArrivals" :heading="$t('landing.new_arrivals')" :link="route('offer.index')"/>
    
    <OffersSection 
        v-if="brandWithMostActiveOffers.length > 2" 
        :offers="brandWithMostActiveOffers" 
        :heading="$t('landing.new_arrivals_from', { brand: brandWithMostActiveOffers[0]?.brand.name })" 
        :link="route('offer.index', {brand: brandWithMostActiveOffers[0].brand_id})"
    />
        
    <BrandsSection v-if="topBrands.length" :brands="topBrands" :heading="$t('landing.top_brands')" :link="route('offer.index', {brand: 1})"/>

    <OffersSection v-if="baseballBats.length > 2" :offers="baseballBats" :heading="$t('landing.baseball_bats')" :link="route('offer.index', {category: 1, sport: 2})"/>

    <OffersSection v-if="baseballBats.length > 2" :offers="baseballBats" :heading="$t('landing.baseball_bats')" :link="route('offer.index', {category: 1, sport: 2})"/>

    <OffersSection v-if="softballBats.length > 2" :offers="softballBats" :heading="$t('landing.softball_bats')" :link="route('offer.index', {category: 1, sport: 3})"/>

    <OffersSection v-if="baseballGear.length > 2" :offers="baseballGear" :heading="$t('landing.baseball_gear')" :link="route('offer.index', {sport: 2})"/>

    <OffersSection v-if="softballGear.length > 2" :offers="softballGear" :heading="$t('landing.softball_gear')" :link="route('offer.index', {sport: 3})"/>

    <!-- TODO: all offers with pagination loading -->
</template>

<script setup>
import BrandsSection from '@/Components/LandingPage/BrandsSection.vue';
import OffersSection from '@/Components/LandingPage/OffersSection.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    newArrivals: Array,
    brandWithMostActiveOffers: Array ?? [],
    baseballBats: Array ?? [],
    softballBats: Array ?? [],
    baseballGear: Array ?? [],
    softballGear: Array ?? [],
    favorites: Array ?? [],
    topBrands: Array ?? [],
});
</script>