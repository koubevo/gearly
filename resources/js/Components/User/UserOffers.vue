<template>
    <!-- TODO: sorting -->
    <OffersGrid :offers="offers" />
</template>

<script setup>
import OffersGrid from '../Offer/OffersGrid.vue';


defineProps({
    offers: Array,
})
</script>