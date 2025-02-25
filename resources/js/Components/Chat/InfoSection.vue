<template>
    <section class="flex flex-col gap-4">
        <Link :href="route('offer.show', {offer: offer})">
            <div class="flex gap-2 items-center">
                <div>
                    <img :src="offer.thumbnail_url" :alt="offer.name" class="h-14" loading="lazy">
                </div>
                <div>
                    <Heading3>{{ offer.name }}</Heading3>
                    <PriceCard :price="offer.price" :currency="offer.currency"/>
                </div>
            </div>
        </Link>
        <Link :href="route('user.show', {user: seller.id})">
            <div class="flex items-center gap-2">
                <Heading3>{{ seller.name }}</Heading3>
                <SmallText>Rating</SmallText>
            </div>
        </Link>
        <Divider class="md:w-full"/>
    </section>
</template>

<script setup>
import Divider from '@/Components/Search/Divider.vue';
import Heading3 from '@/Components/Text/Heading3.vue';
import SmallText from '@/Components/Text/SmallText.vue';
import { Link } from '@inertiajs/vue3';
import PriceCard from '@/Components/Offer/PriceCard.vue';

const props = defineProps({
    seller: Object,
    offer: Object,
});

</script>