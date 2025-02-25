<template>
    <section class="flex flex-col h-[calc(100vh-90px)] max-w-5xl mx-auto">
        <InfoSection :seller="seller" :offer="offer" :buyer="buyer" class="mb-4 flex-shrink-0"/>
        <ChatSection :seller="seller" :offer="offer" :buyer="buyer" class="mb-4 flex-grow overflow-auto"/>
        <section class="flex items-center justify-between gap-4 flex-shrink-0">
            <input type="text" class="input-style" placeholder="Type a message...">
            <button class=""><PaperAirplaneIcon class="w-5 h-5 stroke-[2]"/></button>
        </section>
    </section>
</template>

<script setup>
import ChatSection from "@/Components/Chat/ChatSection.vue";
import InfoSection from "@/Components/Chat/InfoSection.vue";
import { PaperAirplaneIcon } from "@heroicons/vue/24/outline";


const props = defineProps({
    buyer: Object,
    seller: Object,
    offer: Object,
})
</script>