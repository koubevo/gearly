<template>
    <OfferForm :offer="offer" :isEditMode="true" />
</template>

<script setup>
import OfferForm from '@/Components/OfferForm.vue';

const props = defineProps({
    offer: Object,
});
</script>
