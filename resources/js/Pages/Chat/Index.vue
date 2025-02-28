<template>
    <section v-if="chats.length" class="mb-8 max-w-5xl mx-auto">
        <Heading1 class="mb-4">My Chats</Heading1>
        <ChatItem v-for="chat in chats" :key="chat.offer.id" :chat="chat"/>
    </section>
    <NothingHere v-else :text="'To chat with someone, choose any offer and ask about it!'">You have no active chats.</NothingHere>
</template>

<script setup>
import NothingHere from '@/Components/NothingHere.vue';
import ChatItem from '@/Components/Chat/ChatItem.vue';
import Heading1 from '@/Components/Text/Heading1.vue';

defineProps({
    chats: Array,
});
</script>