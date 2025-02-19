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
                <img :src="offer.thumbnail_url" :alt="offer.name" class="mb-2" loading="lazy">
            </div>           
            <!-- TODO: only 1 or 2 lines! -->  
            <Heading3 :text="offer.name"/>
            <SmallText :text="offer.brand.name"/>
            <!-- TODO: size? -->
            <PriceCard :price="offer.price" :currency="offer.currency"/>
        </div>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { HeartIcon } from '@heroicons/vue/24/outline'
import PriceCard from '@/Components/Offer/PriceCard.vue';
import Condition from '@/Components/Offer/Condition.vue';
import Heading3 from '@/Components/Text/Heading3.vue';
import SmallText from '@/Components/Text/SmallText.vue';

const props = defineProps({
  offer: Object
});
</script>