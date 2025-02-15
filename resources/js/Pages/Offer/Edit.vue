<template>
    <OfferForm :offer="offer" :isEditMode="true" :brands="brands" :categories="categories" :deliveryOptions="deliveryOptions" />
</template>

<script setup>
import OfferForm from '@/Components/OfferForm.vue';

const props = defineProps({
    offer: Object,
    brands: Array,
    categories: Array,
    deliveryOptions: Array
});
</script>
