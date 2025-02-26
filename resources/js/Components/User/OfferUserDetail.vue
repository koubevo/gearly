<template>
    <section class="border-s-gray-900 border-4 border-e-0 border-y-0 p-2">
        <Heading3>{{ seller.name }} <span v-if="seller.team">({{ seller.team }})</span></Heading3>
        <!-- TODO: feedback -->
        <NormalText>Feedback</NormalText>
        <NormalText v-if="soldOffersCount > 0" class="mb-2">Already sold items: {{ soldOffersCount }}</NormalText>
        <!-- TODO: premium badge, verified badge -->
        <TinyText :text="seller.location" class="mb-0.5"/>
        <TinyText :text="seller.phone" v-if="seller.phone"/>
    </section>
</template>

<script setup>
import Heading3 from '@/Components/Text/Heading3.vue'
import TinyText from '@/Components/Text/TinyText.vue'
import NormalText from '@/Components/Text/NormalText.vue'
defineProps({
    seller: Object,
    soldOffersCount: Number,
})
</script>