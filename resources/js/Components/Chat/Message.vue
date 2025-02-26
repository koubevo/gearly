<template>
    <div v-if="message.type_id === 1" class="px-3 py-2 inline-block max-w-[60%]" :class="{'bg-primary-900 text-white self-end': message.author_id === currentUser.id, 'bg-gray-200': message.sender_id !== currentUser.id}">
        {{ message.message }}
    </div>
    <div v-if="message.type_id === 2" class="text-center text-primary-900 w-full my-6">
        {{ message.message }}
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const currentUser = page.props.auth?.user;


defineProps({
    message: Object,
});


</script>