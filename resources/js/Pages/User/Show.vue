<template>
    <UserInfo :user="user"/>
    <Divider class="md:w-full my-4"/>
    <UserOffers :offers="offers" class="py-4"/>
</template>

<script setup>
import Divider from '@/Components/Search/Divider.vue';
import UserOffers from '@/Components/User/UserOffers.vue';
import UserInfo from '@/Components/User/UserInfo.vue';

defineProps({
    user: Object,
    offers: Array
})
</script>