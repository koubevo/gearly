<template>
    <OfferForm :isEditMode="false" :brands="brands" :categories="categories" :deliveryOptions="deliveryOptions" />
</template>

<script setup>
import OfferForm from '@/Components/Form/OfferForm.vue';
const props = defineProps({
    brands: Array,
    categories: Array,
    deliveryOptions: Array
});
</script>
