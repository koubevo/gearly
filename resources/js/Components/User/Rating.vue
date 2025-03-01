<template>
  <div class="flex items-center">
    <div class="flex">
      <template v-for="star in 5" :key="star">
        <StarIcon v-if="star <= Math.floor(roundedRating)" class="text-primary-900 w-6 h-6" />

        <div v-else-if="star - 0.5 === roundedRating" class="relative w-6 h-6">
          <StarIcon class="text-primary-900 absolute inset-0" style="clip-path: polygon(0 0, 50% 0, 50% 100%, 0 100%);" />
          <StarOutlineIcon class="text-primary-900 absolute inset-0" />
        </div>

        <StarOutlineIcon v-else class="text-gray-300 w-6 h-6" />
      </template>
    </div>
    <span class="ml-2 text-gray-600" v-if="rating.count">{{ rating.stars }} ({{ rating.count }}x)</span>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { StarIcon } from '@heroicons/vue/24/solid';
import { StarIcon as StarOutlineIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
  rating: Object
});

const roundedRating = computed(() => Math.round(props.rating.stars * 2) / 2);
</script>
  