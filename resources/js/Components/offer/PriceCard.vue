<template>
    <BoldNormalText class="uppercase">{{ price }} {{ currency }}</BoldNormalText>
</template>

<script setup>
import { computed } from 'vue';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';

const props = defineProps({
  price: Number,
  currency: String
});

const price = computed(() => {
    if (props.price == null) return "0";
    const numericPrice = Number(props.price);
    return new Intl.NumberFormat('cs-CZ').format(numericPrice);
});
</script>