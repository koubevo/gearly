<template>
    <Heading2 class="uppercase">{{ price }} {{ currency }}</Heading2>
</template>

<script setup>
import { computed } from 'vue';
import Heading2 from '@/Components/Text/Heading2.vue';

const props = defineProps({
  price: String,
  currency: String
});

const price = computed(() => {
    if (props.price == null) return "0";
    const numericPrice = Number(props.price);
    return new Intl.NumberFormat('cs-CZ').format(numericPrice);
});
</script>