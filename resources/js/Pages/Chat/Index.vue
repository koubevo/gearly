<template>
    <section v-if="chats.length" class="my-8">
        <Heading2 class="mb-4">My Chats</Heading2>
        <ChatItem v-for="chat in chats" :key="chat.offer.id" :chat="chat"/>
    </section>
    <NothingHere v-else :text="'To chat with someone, choose any offer and ask about it!'">You have no active chats.</NothingHere>
</template>

<script setup>
import NothingHere from '@/Components/NothingHere.vue';
import ChatItem from '@/Components/Chat/ChatItem.vue';
import Heading2 from '@/Components/Text/Heading2.vue';

defineProps({
    chats: Array,
});
</script>