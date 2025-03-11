<template>
    <div class="w-full my-0.5 flex flex-col justify-center">
        <Link class="text-left w-full" :href="route('chat.show', {offer: chat.offer.id, buyer: chat.buyer_id})">
            <div class="p-3 w-full flex flex-row justify-between items-center gap-2">
                <div class="w-10 flex-shrink-0"><img :src="chat.offer.thumbnail_url" alt="Offer image" class="w-full object-cover object-center scale-150 card-image" ></div>
                <div class="flex-1 ps-4">
                    <div class="grid">
                        <div class="flex gap-2 items-center">
                            <Condition :condition="chat.offer.status" :conditionNumber="chat.offer.statusNumber" :type="'status'" />
                            <BoldNormalText>{{ chat.offer.name }}</BoldNormalText>
                        </div>
                        <SmallText v-if="chat.buyer_id !== user.id">{{ chat.buyer_name }}</SmallText>
                        <SmallText v-else>{{ chat.seller_name }}</SmallText>
                        <TinyText>{{ chat.last_message_time }}</TinyText>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <div class="flex gap-2 items-center">
                        <PriceCard :price="chat.offer.price" :currency="chat.offer.currency" />
                        <div class="text-primary-900"><ChevronRightIcon class="w-5 h-5  stroke-[2.5]" /></div>
                    </div>
                </div>
            </div>    
        </Link>
        <Divider class="md:w-full my-2"/>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import Divider from '@/Components/Search/Divider.vue';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';
import PriceCard from '@/Components/Offer/PriceCard.vue';
import SmallText from '@/Components/Text/SmallText.vue';
import Condition from '@/Components/Offer/Condition.vue';
import TinyText from '../Text/TinyText.vue';

const user = usePage().props.auth.user ?? {};

defineProps({
    chat: Object
})
</script>