<template>
    <span :class="['h-full uppercase font-medium inline-block px-2', conditionClass]" v-if="(conditionNumber !== 1 && conditionNumber !== 4 && conditionNumber !== 5 && type === 'status') || type === 'condition'">  
      {{ condition }}
    </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  condition: String,
  conditionNumber: Number,
  type: String,
});

const conditionClass = computed(() => {
if (props.type === 'condition') {
    switch (props.conditionNumber) {
    case 1:
      return 'bg-primary-900 text-white';
    case 2:
      return 'bg-yellow-500 text-black';
    case 3:
      return 'bg-red-500 text-white';
  }
}

if (props.type === 'status') {
    switch (props.conditionNumber) {
    case 2:
      return 'bg-black text-white';
    case 3:
      return 'bg-black text-white';
  }
}
  
});
</script>