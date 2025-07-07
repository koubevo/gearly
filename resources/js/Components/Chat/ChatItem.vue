<template>
    <div class="w-full my-0.5 flex flex-col justify-center">
        <Link class="text-left w-full" :href="route('chat.show', {offer: chat.offer.id, buyer: chat.buyer.id})">
            <div class="p-3 w-full flex flex-row justify-between items-center gap-2">
                <div class="w-10 flex-shrink-0"><img :src="chat.offer.thumbnail_url" alt="Offer image" class="w-full object-cover object-center scale-150 card-image" ></div>
                <div class="flex-1 ps-4">
                    <div class="grid">
                        <div class="flex flex-col md:flex-row">
                            <div class="inline-flex items-center">
                                <Condition :condition="chat.offer.status" :conditionNumber="chat.offer.statusNumber" :type="'status'" />
                            </div>
                            <BoldNormalText>{{ chat.offer.name }}</BoldNormalText>
                        </div>
                        <SmallText class="flex items-center gap-1">
                            {{ chatUser.name }}
                            <VerifiedBadge v-if="chatUser.gearly_verified" />
                            <PremiumBadge v-if="chatUser.is_premium" />
                        </SmallText>
                        <TinyText>{{ chat.last_message_time }}</TinyText>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <div class="flex gap-2 items-center">
                        <PriceCard :price="chat.offer.price" :currency="chat.offer.currency" />
                        <div v-if="chat.unread_count > 0" class="text-white bg-primary-900 rounded-full w-4 h-4 flex items-center justify-center text-[11px]">
                            {{ chat.unread_count }}
                        </div>
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
import { computed } from 'vue';
import VerifiedBadge from '@/Components/User/VerifiedBadge.vue';
import PremiumBadge from '@/Components/User/PremiumBadge.vue';

const user = usePage().props.auth.user ?? {};

const props = defineProps({
    chat: Object
});

const chatUser = computed(() => {
    if (props.chat.buyer.id === user.id) {
        return props.chat.seller;
    }
    return props.chat.buyer;
});
</script>