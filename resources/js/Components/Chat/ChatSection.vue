<template>
    <section class="overflow-y-auto h-[80vh]">
        <div class="flex flex-col gap-2 items-start">
            <Message v-for="message in messages" :key="message.id" :message="message"/>
        </div>
    </section>
</template>

<script setup>
import Message from "@/Components/Chat/Message.vue";

const props = defineProps({
    seller: Object,
    offer: Object,
    messages: Array,
});

</script>