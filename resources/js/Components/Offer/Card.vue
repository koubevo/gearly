<template>
    <Link :href="route('offer.show', offer.id)">
        <div class="bg-white h-full">
            <div>
                <img :src="offer.thumbnail_url" :alt="offer.name" class="card-image" loading="lazy">
            </div>  
            <div class="py-2 flex flex-col gap-2"> 
                <div class="flex align-top items-start">
                    <ConditionLike :offer="offer"/>
                </div>
                <div class="flex-1">
                    <Heading3 :text="offer.name" class="line-clamp-2 lg:line-clamp-1"/>
                    <SmallText :text="offer.brand.name"/>
                    <PriceCard :price="offer.price" :currency="offer.currency"/>
                </div>
            </div>         
        </div>
    </Link>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import PriceCard from '@/Components/Offer/PriceCard.vue';
    import Heading3 from '@/Components/Text/Heading3.vue';
    import SmallText from '@/Components/Text/SmallText.vue';
    import ConditionLike from '@/Components/Offer/ConditionLike.vue';

    const props = defineProps({
      offer: Object
    });
</script>
