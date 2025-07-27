<template>
    <section class="mb-8">
        <div class="mb-2 grid grid-cols-1 bg-primary-900 p-4 md:p-8 pb-8">
            <Heading2 class="mb-4 text-white">{{ heading }}</Heading2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 items-stretch">
                <Brand v-for="brand in brands" :brand="brand" class="h-full"/>
            </div>
        </div>
    </section>
</template>

<script setup>
import Heading2 from '@/Components/Text/Heading2.vue';
import Brand from '@/Components/LandingPage/Brand.vue';

defineProps({
    brands: {
        type: Array ?? [],
    },
    heading: String
});
</script>