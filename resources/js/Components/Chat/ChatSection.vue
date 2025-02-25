<template>
    <section class="overflow-y-auto h-[80vh]">
        <div class="flex flex-col gap-2 items-start">
            <Message v-for="message in messages" :key="message.id" :message="message"/>
        </div>
    </section>
</template>

<script setup>
import { ref } from "vue";
import Message from "@/Components/Chat/Message.vue";

const messages = ref([
    {
        id: 1,
        text: "Hello",
        sender_id: 1,
        type_id: 1,
        created_at: "2021-10-10 10:00:00",
    },
    {
        id: 2,
        text: "Hi there!",
        sender_id: 2,
        type_id: 1,
        created_at: "2021-10-10 10:01:00",
    },
    {
        id: 3,
        text: "How are you?",
        sender_id: 1,
        type_id: 1,
        created_at: "2021-10-10 10:02:00",
    },
    {
        id: 4,
        text: "I'm doing well, thanks for asking. awd awd awd awd aw dawd awdnawn danwd uinawd nawidn iwabd ianwid nawidn uiwand uiawnd juinawd nuiwadn uiawnd uiwauid nwadn iwadn uiwadn uiawdjui nawd nadn wadn uiwadn uinwad n",
        sender_id: 2,
        type_id: 1,
        created_at: "2021-10-10 10:03:00",
    },
    {
        id: 5,
        text: "I'm doing well, thanks for asking.",
        sender_id: 1,
        type_id: 1,
        created_at: "2021-10-10 10:04:00",
    },
    {
        id: 6,
        text: "What are you up to today?",
        sender_id: 2,
        type_id: 1,
        created_at: "2021-10-10 10:05:00",
    },
    {
        id: 7,
        text: "Just working on a project. You?",
        sender_id: 1,
        type_id: 1,
        created_at: "2021-10-10 10:06:00",
    },
    {
        id: 8,
        text: "Same here. Busy day!",
        sender_id: 2,
        type_id: 1,
        created_at: "2021-10-10 10:07:00",
    },
    {
        id: 9,
        text: "Yeah, it sure is.",
        sender_id: 1,
        type_id: 1,
        created_at: "2021-10-10 10:08:00",
    },
    {
        id: 10,
        text: "Let's catch up later.",
        sender_id: 2,
        type_id: 1,
        created_at: "2021-10-10 10:09:00",
    },
    {
        id: 11,
        text: "Sounds good. Talk to you soon!",
        sender_id: 1,
        type_id: 1,
        created_at: "2021-10-10 10:10:00",
    }
]);

const props = defineProps({
    seller: Object,
    offer: Object,
});

const newMessage = ref("");

</script>