<template>
    <Head :title="'Edit Offer ' + offer.name" />
    <OfferForm :offer="offer" :isEditMode="true" :brands="brands" :categories="categories" :deliveryOptions="deliveryOptions" />
</template>

<script setup>
import OfferForm from '@/Components/Form/OfferForm.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    offer: Object,
    brands: Array,
    categories: Array,
    deliveryOptions: Array
    });
</script>
