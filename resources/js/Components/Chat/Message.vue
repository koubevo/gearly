<template>
    <div v-if="message.type_id === 1" class="px-3 py-2 inline-block max-w-[60%]" :class="{'bg-primary-900 text-white self-end': message.author_id === currentUser.id, 'bg-gray-200': message.sender_id !== currentUser.id}">
        {{ message.message }}
    </div>
    <div v-if="message.type_id === 2" class="my-6 mx-auto">
        <div class="text-center text-primary-900 w-full">{{ message.message }}</div>
        <TinyText class="text-center ">{{ formattedDate }}</TinyText>
    </div>
    <div v-if="message.type_id === 3" class="my-6 mx-auto">
        <div class="text-center text-gray-700 w-full">{{ message.message }}</div>
        <TinyText class="text-center ">{{ formattedDate }}</TinyText>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import TinyText from '../Text/TinyText.vue';

const page = usePage();
const currentUser = page.props.auth?.user;

const props = defineProps({
    message: Object,
});

const formattedDate = new Date(props.message.created_at).toLocaleString('en-GB', {
    hour: '2-digit',
    minute: '2-digit',
    day: '2-digit',
    month: '2-digit',
    hour12: false,
});

</script>