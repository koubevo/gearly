<template>
    <section class="flex flex-col gap-4">
        <Link :href="route('offer.show', {offer: offer})">
            <div class="flex gap-2 items-center">
                <div>
                    <img :src="offer.thumbnail_url" :alt="offer.name" class="h-14 card-image" loading="lazy">
                </div>
                <div>
                    <div class="flex gap-2 items-center">
                        <Condition :condition="offer.status" :conditionNumber="offer.statusNumber" :type="'status'"/>
                        <Heading3>{{ offer.name }}</Heading3>
                    </div>
                    <PriceCard :price="offer.price" :currency="offer.currency"/>
                    <TinyText>{{ offer.delivery_option_name }}</TinyText>
                </div>
            </div>
        </Link>
        <Link :href="route('user.show', {user: userInfo.id})">
            <div class="flex flex-col md:flex-row md:items-center md:gap-2">
                <Heading3 class="flex items-center gap-1">{{ userInfo.name }}
                    <VerifiedBadge v-if="userInfo.gearly_verified" />
                    <PremiumBadge v-if="userInfo.is_premium" />
                    <Rating :rating="rating"/>
                </Heading3>
            </div>
        </Link>
        <Divider class="md:w-full"/>
    </section>
</template>

<script setup>
import Divider from '@/Components/Search/Divider.vue';
import Heading3 from '@/Components/Text/Heading3.vue';
import { Link } from '@inertiajs/vue3';
import PriceCard from '@/Components/Offer/PriceCard.vue';
import Condition from '@/Components/Offer/Condition.vue';
import Rating from '@/Components/User/Rating.vue';
import TinyText from '@/Components/Text/TinyText.vue';
import VerifiedBadge from '@/Components/User/VerifiedBadge.vue';
import PremiumBadge from '@/Components/User/PremiumBadge.vue';

const props = defineProps({
    buyer: Object,
    seller: Object,
    offer: Object,
    rating: Object,
    userInfo: Object
});
</script>