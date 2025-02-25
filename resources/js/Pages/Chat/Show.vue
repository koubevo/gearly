<template>
    <section class="">
        <InfoSection :seller="seller" :offer="offer" class="mb-4"/>
        <ChatSection :seller="seller" :offer="offer" class="mb-4"/>
        <section class="flex items-center justify-between gap-4">
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
    seller: Object,
    offer: Object,
})
</script>