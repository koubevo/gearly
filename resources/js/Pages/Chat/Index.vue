<template>
<!-- TODO: all chats else dogie -->
    <section v-if="myOffers.length" class="my-8">
        <Heading2 class="mb-4">My Offers</Heading2>
        <ChatItem v-for="offer in myOffers" :key="offer.id" :offer="offer"/>
    </section>
    <section v-if="otherOffers.length" class="my-8">
        <Heading2 class="mb-4">Other Offers</Heading2>
        <ChatItem v-for="offer in otherOffers" :key="offer.id" :offer="offer"/>
    </section>
    <NothingHere v-if="!otherOffers.length && !myOffers.length" :text="'To chat with someone, choose any offer and ask about it!'">You have no active chats.</NothingHere>
</template>

<script setup>
import NothingHere from '@/Components/NothingHere.vue';
import ChatItem from '@/Components/Chat/ChatItem.vue';
import Heading2 from '@/Components/Text/Heading2.vue';

defineProps({
    myOffers: Array,
    otherOffers: Array,
});
</script>