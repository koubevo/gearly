<template>
    <section class="overflow-y-auto h-[80vh]">
        <div class="flex flex-col gap-2 items-start">
            <Message v-for="message in messages" :key="message.id" :message="message"/>
            <NormalText class="text-center self-center mt-10 text-primary-900" v-if="!messages.length">Start the conversation with a message!</NormalText>
        </div>
    </section>
</template>

<script setup>
import Message from "@/Components/Chat/Message.vue";
import NormalText from "@/Components/Text/NormalText.vue";

const props = defineProps({
    seller: Object,
    offer: Object,
    messages: Array,
});

</script>