<template>
    <Link :href="route('offer.index', {brand: brand.brand_id})" class="h-full block">
        <div class="flex flex-col justify-center items-center border-2 border-black p-10 bg-white h-full">
            <img :src="'/storage/imgs/' + brand.logo" alt="Brand logo" class="w-20 object-cover object-center">
            <Heading3 class="text-center mt-2">{{ brand.brand_name }} ({{ brand.offer_count }})</Heading3>
        </div>
    </Link>
</template>

<script setup>
import Heading3 from '@/Components/Text/Heading3.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    brand: Object,
});

</script>