<template>
    <section class="border-s-gray-900 border-4 border-e-0 border-y-0 p-2">
        <Heading3 class="mb-2">{{ seller.name }} <span v-if="seller.team">({{ seller.team }})</span></Heading3>
        <Rating class="mb-1" :rating="rating"/>
        <SmallText v-if="soldOffersCount > 0" class="mb-1">Already sold items: {{ soldOffersCount }}</SmallText>
        <!-- TODO: premium badge, verified badge -->
        <TinyText :text="seller.location" class="mb-0.5"/>
    </section>
</template>

<script setup>
import Heading3 from '@/Components/Text/Heading3.vue'
import TinyText from '@/Components/Text/TinyText.vue'
import SmallText from '@/Components/Text/SmallText.vue'
import Rating from '@/Components/User/Rating.vue';

defineProps({
    seller: Object,
    soldOffersCount: Number,
    rating: Object
})
</script>