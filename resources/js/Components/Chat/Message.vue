<template>
    <div v-if="message.type_id === 1" class="px-3 py-2 inline-block max-w-[60%]" :title="message.created_at_formatted" :class="{'bg-primary-900 text-white self-end': message.author_id === currentUser.id, 'bg-gray-200': message.sender_id !== currentUser.id}">
        {{ message.message }}
    </div>
    <div v-if="message.type_id === 2" class="my-6 mx-auto">
        <div class="text-center text-primary-900 w-full">{{ message.message }}</div>
        <TinyText class="text-center">{{ message.created_at_formatted }}</TinyText>
    </div>
    <div v-if="message.type_id === 3" class="my-6 mx-auto">
        <div class="text-center text-gray-700 w-full">{{ message.message }}</div>
        <TinyText class="text-center">{{ message.created_at_formatted }}</TinyText>
    </div>
    <div v-if="message.type_id === 4" class="my-6 mx-auto flex flex-col items-center">
        <div class="text-center text-gray-700 w-full">{{ message.message }}</div>
        <Rating :rating="rating" class="my-1"/>
        <TinyText class="text-center">{{ message.created_at_formatted }}</TinyText>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import TinyText from '@/Components/Text/TinyText.vue';
import Rating from '@/Components/User/Rating.vue';

const page = usePage();
const currentUser = page.props.auth?.user;

const props = defineProps({
    message: Object,
});

const rating = {
    stars: props.message.stars,
}

</script>