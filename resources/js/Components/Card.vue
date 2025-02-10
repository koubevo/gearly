<template>
    <Link :href="route('offer.show', offer.id)">
        <div class="bg-white p-2 shadow-gray-300 shadow-lg">
            <div class="relative">
                <span class="absolute top-1 right-1 py-1 flex align-middle gap-2">
                    <!-- TODO: bg depending on condition -->
                    <span class="bg-primary-900 h-full uppercase font-medium inline-block px-2">{{ offer.condition }}</span>
                    <!-- TODO: adding to wishlist, background -->
                    <button><HeartIcon class="w-5 h-5 mt-0.5" /></button>
                </span>
                <!-- TODO: scaled img -->
                <img :src="'storage/imgs/nike.jpg'" :alt="offer.name" class="mb-2">
            </div>
            <!-- TODO: brand -->
            <p class="text-xs text-gray-700">{{ offer.brand }}</p>
            <h3 class="font-medium mb-2">{{ offer.name }}</h3>
            <p class="font-black uppercase">{{ price }} {{ offer.currency }}</p>
        </div>
    </Link>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { HeartIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  offer: Object
});

const price = computed(() => {
    if (!props.offer || props.offer.price == null) return "0"; // Ochrana proti undefined/null
    const numericPrice = Number(props.offer.price); // Převod na číslo
    return numericPrice % 1 === 0 ? numericPrice.toFixed(0) : numericPrice.toFixed(2);
});
</script>