<template>
    <section class="overflow-y-auto h-[80vh]" ref="chatSection">
        <div class="flex flex-col gap-2 items-start">
            <Message v-for="message in messages" :key="message.id" :message="message" v-if="messages.length"/>
            <NormalText class="text-center self-center mt-10 text-primary-900" v-else>
                Start the conversation with a message!
            </NormalText>
        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted, watch, nextTick } from "vue";
import Message from "@/Components/Chat/Message.vue";
import NormalText from "@/Components/Text/NormalText.vue";
import axios from "axios";

const props = defineProps({
    seller: Object,
    buyer: Object,
    offer: Object,
});

const messages = ref([]);
const lastMessageId = ref(0);
const chatSection = ref(null); 

const channelName = computed(() => `chat.${props.offer.id}.${props.buyer.id}`);

const scrollToBottom = () => {
    nextTick(() => {
        if (chatSection.value) {
            chatSection.value.scrollTo({ top: chatSection.value.scrollHeight, behavior: "smooth" });
        }
    });
};

async function loadInitialMessages() {
    try {
        const response = await axios.get(route('chat.load', { offer: props.offer.id, buyer: props.buyer.id }));
        messages.value = response.data.messages;

        if (messages.value.length > 0) {
            lastMessageId.value = messages.value[messages.value.length - 1].id;
        }
        scrollToBottom();
    } catch (error) {
        console.error("err");
    }
}

onMounted(() => {
    loadInitialMessages();

    window.Echo.private(channelName.value)
    .listen("MessageSent", (e) => {
        if (!messages.value.some(msg => msg.id === e.message.id)) {
            messages.value.push(e.message);
            lastMessageId.value = e.message.id;
        }
        scrollToBottom();
        axios.post(route('chat.read', { offer: props.offer.id, buyer: props.buyer.id }));
    });
});

watch(messages, scrollToBottom, { deep: true });

defineExpose({
    messagesCount: computed(() => messages.value.length)
});
</script>
