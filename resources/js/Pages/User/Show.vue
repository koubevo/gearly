<template>
    <div class="mb-4">
        <UserInfo :user="user" :soldOffersCount="soldOffersCount" :rating="rating" :receivedRatings="receivedRatings"/>
        <Divider class="md:w-full mt-8"/>
        <UserOffers :offers="activeOffers" class="py-4" v-if="activeOffers.length" :heading="'Active offers'"/>
        <UserOffers :offers="soldOffers" class="py-4" v-if="soldOffers.length" :heading="'Sold offers'"/>
        <NothingHere v-if="!activeOffers.length && !soldOffers.length" :text="'User has no active or sold offers'">We found no offers</NothingHere>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Divider from '@/Components/Search/Divider.vue';
import UserOffers from '@/Components/User/UserOffers.vue';
import UserInfo from '@/Components/User/UserInfo.vue';
import NothingHere from '@/Components/NothingHere.vue';
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    user: Object,
    activeOffers: Array ?? [],
    soldOffers: Array ?? [],
    soldOffersCount: Number,
    rating: Object,
    receivedRatings: Array
});

const page = usePage();
const currentUser = page.props.auth?.user;

onMounted(() => {
    if (currentUser.id === props.user.id) {
        Inertia.visit(route('profile.edit'));
    }
});
</script>