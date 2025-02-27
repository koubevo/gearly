<template>
    <div class="w-full my-0.5 flex flex-col justify-center">
        <Link class="text-left w-full" :href="route('chat.show', {offer: offer.id})">
            <div class="p-3 w-full flex flex-row justify-between items-center gap-4">
                <div class="w-10 flex-shrink-0"><img :src="offer.thumbnail_url" alt="Offer image" class="w-full object-cover object-center scale-150"></div>
                <!-- TODO: seller/buyer name -->
                <div class="flex-1 ps-4"><BoldNormalText>{{ offer.name }}</BoldNormalText></div>
                <div class="flex-shrink-0">
                    <div class="flex gap-2 items-center">
                        <PriceCard :price="offer.price" :currency="offer.currency" />
                        <div class="text-primary-900"><ChevronRightIcon class="w-5 h-5  stroke-[2.5]" /></div>
                    </div>
                </div>
            </div>    
        </Link>
        <Divider class="md:w-full my-2"/>
    </div>
    
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Divider from '@/Components/Search/Divider.vue';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';
import PriceCard from '@/Components/Offer/PriceCard.vue';

defineProps({
    offer: Object
})
</script>