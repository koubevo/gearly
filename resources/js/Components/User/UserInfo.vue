<template>
    <section class="mb-4 flex gap-4 items-center">
        <!-- TODO: premium badge, verified badge -->
        <Heading1>{{ user.name }}</Heading1>
    </section>
    <section class="mb-4">
        <NormalText>Feedback</NormalText>
        <NormalText v-if="soldOffersCount > 0" class="mb-2">Already sold items: {{ soldOffersCount }}</NormalText>
        <!-- TODO: count of selled items  -->
        <TinyText :text="user.location" class="mb-0.5"/>
        <TinyText :text="user.phone" v-if="user.phone"/>
    </section>
</template>

<script setup>
import Heading1 from '@/Components/Text/Heading1.vue'
import TinyText from '@/Components/Text/TinyText.vue'
import NormalText from '@/Components/Text/NormalText.vue'

defineProps({
    user: Object,
    soldOffersCount: Number,
})
</script>