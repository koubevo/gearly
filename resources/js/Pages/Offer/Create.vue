<template>
    <Head :title="$t('offer.add_new_offer')" />
    <OfferForm :isEditMode="false" :brands="brands" :categories="categories" :deliveryOptions="deliveryOptions" :freeLimitExceeded="freeLimitExceeded" :limit/>
</template>

<script setup>
import OfferForm from '@/Components/Form/OfferForm.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    brands: Array,
    categories: Array,
    deliveryOptions: Array,
    freeLimitExceeded: Boolean,
    limit: Number,
});
</script>
