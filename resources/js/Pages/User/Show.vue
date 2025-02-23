<template>
    <div class="mb-4">
        <UserInfo :user="user" :soldOffersCount="soldOffersCount"/>
        <Divider class="md:w-full mt-8"/>
        <UserOffers :offers="activeOffers" class="py-4" v-if="activeOffers.length" :heading="'Active offers'"/>
        <UserOffers :offers="soldOffers" class="py-4" v-if="soldOffers.length" :heading="'Sold offers'"/>
    </div>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Divider from '@/Components/Search/Divider.vue';
import UserOffers from '@/Components/User/UserOffers.vue';
import UserInfo from '@/Components/User/UserInfo.vue';

defineProps({
    user: Object,
    activeOffers: Array ?? [],
    soldOffers: Array ?? [],
    soldOffersCount: Number,
});

const page = usePage();
const currentUser = page.props.auth?.user;

onMounted(() => {
    if (currentUser === user) {
        router.visit('/profile');
    }
});
</script>