<template>
    <span v-if="allowed.includes(condition)" :class="['h-full uppercase font-medium inline-block px-2', conditionClass]">
      <!-- TODO: transaltions -->
      {{ condition === 'received' ? 'sold' : condition }}
    </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  condition: String
});

const allowed = ['new', 'used', 'damaged', 'sold', 'received'];

const conditionClass = computed(() => {
  switch (props.condition) {
    case 'new':
      return 'bg-primary-900 text-white';
    case 'used':
      return 'bg-yellow-500 text-black';
    case 'damaged':
      return 'bg-red-500 text-white';
    case 'sold':
      return 'bg-black text-white';
    case 'received':
      return 'bg-black text-white';
  }
});
</script>