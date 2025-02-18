<template>
    <span :class="['h-full uppercase font-medium inline-block px-2', conditionClass]">
      {{ condition }}
    </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  condition: String
});

const conditionClass = computed(() => {
  switch (props.condition) {
    case 'new':
      return 'bg-primary-900 text-white';
    case 'used':
      return 'bg-yellow-500 text-black';
    case 'damaged':
      return 'bg-red-500 text-white';
  }
});
</script>