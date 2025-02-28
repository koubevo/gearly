<template>
    <section class="mb-2 flex gap-4 items-center">
        <!-- TODO: premium badge, verified badge -->
        <Heading1>{{ user.name }}</Heading1>
    </section>
    <section class="mb-4">
        <Rating :rating="rating" class="mb-1"/>
        <SmallText v-if="soldOffersCount > 0" class="mb-1">Already sold items: {{ soldOffersCount }}</SmallText>
        <TinyText :text="user.location" class="mb-0.5"/>
    </section>
</template>

<script setup>
import Heading1 from '@/Components/Text/Heading1.vue'
import TinyText from '@/Components/Text/TinyText.vue'
import SmallText from '@/Components/Text/SmallText.vue'
import Rating from './Rating.vue';

defineProps({
    user: Object,
    soldOffersCount: Number,
    rating: Object
})
</script>