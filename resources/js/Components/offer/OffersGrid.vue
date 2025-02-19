<template>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8">
        <Card v-for="offer in offers.data" :key="offer.id" :offer="offer"/>
    </div>
    <Pagination v-if="offers.links" :links="offers.links" :previous="offers.prev_page_url" :next="offers.next_page_url"/>
</template>

<script setup>
import Card from '@/Components/Offer/Card.vue';
import Pagination from '@/Components/Offer/Pagination.vue';

defineProps({
  offers: Object
});
</script>