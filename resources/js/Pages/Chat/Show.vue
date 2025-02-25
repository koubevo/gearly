<template>
    <section class="">
        <ChatSection :receiver="receiver" class="mb-4"/>
        <section class="flex items-center justify-between gap-4">
            <input type="text" class="input-style" placeholder="Type a message...">
            <button class=""><PaperAirplaneIcon class="w-5 h-5 stroke-[2]"/></button>
        </section>
    </section>
</template>

<script setup>
import ChatSection from "@/Components/Chat/ChatSection.vue";
import { PaperAirplaneIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    receiver: Object,
})
</script>