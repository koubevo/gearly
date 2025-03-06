<template>
    <Head :title="$t('chat.your_chats')" />
    <section v-if="chats.length" class="mb-8 max-w-5xl mx-auto">
        <Heading1 class="mb-4">{{ $t('chat.your_chats') }}</Heading1>
        <ChatItem v-for="chat in chats" :key="chat.offer.id" :chat="chat"/>
    </section>
    <NothingHere v-else :text="$t('chat.to_chat_with_someone')">{{ $t('chat.you_have_no_chats') }}</NothingHere>
</template>

<script setup>
import NothingHere from '@/Components/NothingHere.vue';
import ChatItem from '@/Components/Chat/ChatItem.vue';
import Heading1 from '@/Components/Text/Heading1.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    chats: Array,
});
</script>