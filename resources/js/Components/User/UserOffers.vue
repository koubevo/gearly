<template>
    <div>
        <!-- TODO: sorting, count -->
        <Heading2>{{ heading }}</Heading2>
        <UserOffersGrid :offers="offers" />
    </div>
</template>

<script setup>
import UserOffersGrid from '../Offer/UserOffersGrid.vue';
import Heading2 from '@/Components/Text/Heading2.vue';


defineProps({
    offers: Array,
    heading: String,
})
</script>