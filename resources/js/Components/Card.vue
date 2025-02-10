<template>
    <Link :href="route('offer.show', offer.id)">
        <div class="bg-white p-2 shadow-gray-300 shadow-lg">
            <div class="relative">
                <span class="absolute top-1 right-1 py-1 flex align-middle gap-2">
                    <Condition :condition="offer.condition"/>
                    <!-- TODO: adding to wishlist, background, move to component -->
                    <button><HeartIcon class="w-5 h-5 mt-0.5" /></button>
                </span>
                <!-- TODO: scaled img -->
                <img :src="'storage/imgs/nike.jpg'" :alt="offer.name" class="mb-2">
            </div>
            <!-- TODO: brand, move to component -->
            <p class="text-xs text-gray-700">{{ offer.brand }}</p>
            <Heading3 :text="offer.name"/>
            <Price :price="offer.price" :currency="offer.currency"/>
        </div>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { HeartIcon } from '@heroicons/vue/24/outline'
import Price from './Price.vue';
import Condition from './Condition.vue';
import Heading3 from './Heading3.vue';

const props = defineProps({
  offer: Object
});
</script>