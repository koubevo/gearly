<template>
    <section class="overflow-y-auto h-[80vh]">
        <div class="flex flex-col gap-2 items-start">
            <Message v-for="message in messages" :key="message.id" :message="message" v-if="messages.length"/>
            <NormalText class="text-center self-center mt-10 text-primary-900" v-else>Start the conversation with a message!</NormalText>
        </div>
    </section>
</template>

<script setup>
import Message from "@/Components/Chat/Message.vue";
import NormalText from "@/Components/Text/NormalText.vue";
import axios from "axios";
import { onMounted } from "vue";
import { ref } from "vue";

const props = defineProps({
    seller: Object,
    buyer: Object,
    offer: Object,
});

const messages = ref([]);
let lastMessageId = 0;

async function loadInitialMessages() {
    try {
        const response = await axios.get(route('chat.load', { offer: props.offer, buyer: props.buyer }));
        messages.value = response.data.messages;
        if (messages.value.length > 0) {
            lastMessageId = messages.value[messages.value.length - 1].id;
        }
    } catch (error) {
        console.error("err");
    }
}

async function fetchNewMessages() {
    try {
        const response = await axios.get(route('chat.latest', { offer: props.offer, buyer: props.buyer, last_id: lastMessageId }));
        const newMessages = response.data;

        if (newMessages.length > 0) {
            messages.value.push(...newMessages);
            lastMessageId = newMessages[newMessages.length - 1].id;
        }

        fetchNewMessages();
    } catch (error) {
        console.error("Chyba při načítání nových zpráv", error);
        setTimeout(fetchNewMessages, 5000);
    }
}

onMounted(() => {
    loadInitialMessages().then(() => {
        fetchNewMessages();
    });
});
</script>