<template>
  <div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8">
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