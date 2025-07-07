<template>
  <div>
    <div class="offers-grid">
      <Card v-for="offer in offers" :key="offer.id" :offer="offer" v-if="offers.length" />
    </div>
  </div>
</template>

<script setup>
import Card from "@/Components/Offer/Card.vue";

defineProps({
    offers: {
        type: Array,
        default: () => []
    }
})
</script>