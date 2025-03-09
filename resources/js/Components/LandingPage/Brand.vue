<template>
    <Link :href="route('offer.index', {brand: brand.brand_id})">
        <div class="flex justify-center items-center border-2 border-black p-10 bg-white">
            <Heading3>{{ brand.brand_name }} ({{ brand.offer_count }})</Heading3>
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