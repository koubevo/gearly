<template>
    <Head :title="'Your Wishlist'" />
    <div class="mb-4">
        <Heading1>Wishlist</Heading1>
        <Divider class="md:w-full mt-6"/>
        <UserOffers :offers="offers" class="py-2" v-if="offers.length"/>
        <NothingHere v-else :text="'You have not liked any offers. Click the hearth icon to add your first favorite offer to a wishlist!'">Wishlist is empty</NothingHere>
    </div>
</template>

<script setup>
import Divider from '@/Components/Search/Divider.vue';
import UserOffers from '@/Components/User/UserOffers.vue';
import NothingHere from '@/Components/NothingHere.vue';
import Heading1 from '@/Components/Text/Heading1.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    offers: Array,
});
</script>