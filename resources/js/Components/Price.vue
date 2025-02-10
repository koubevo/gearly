<template>
     <p class="font-black uppercase">{{ price }} {{ currency }}</p>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  price: Number,
  currency: String
});

const price = computed(() => {
    if (props.price == null) return "0";
    const numericPrice = Number(props.price);
    return numericPrice % 1 === 0 ? numericPrice.toFixed(0) : numericPrice.toFixed(2);
});
</script>