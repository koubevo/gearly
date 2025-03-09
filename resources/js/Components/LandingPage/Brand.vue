<template>
    <div class="flex justify-center items-center border-2 border-black p-10 bg-white">
        <Heading3>{{ brand.brand_name }}</Heading3>
        <!-- TODO: Count -->
    </div>
</template>

<script setup>
import Heading3 from '@/Components/Text/Heading3.vue';

defineProps({
    brand: Object,
});

</script>