<template>
    <UserInfo :user="user"/>
    <Divider class="md:w-full my-4"/>
    <UserOffers :offers="activeOffers" class="py-4" v-if="activeOffers.length" :heading="'Active offers'"/>
    <Divider class="md:w-full my-4" v-if="activeOffers.length && soldOffers.length"/>
    <UserOffers :offers="soldOffers" class="py-4" v-if="soldOffers.length" :heading="'Sold offers'"/>
</template>

<script setup>
import Divider from '@/Components/Search/Divider.vue';
import UserOffers from '@/Components/User/UserOffers.vue';
import UserInfo from '@/Components/User/UserInfo.vue';

defineProps({
    user: Object,
    activeOffers: Array ?? [],
    soldOffers: Array ?? [],
})
</script>