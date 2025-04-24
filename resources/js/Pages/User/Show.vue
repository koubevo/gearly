<template>
    <Head :title="user.name" />
    <div class="mb-4">
        <UserInfo :user="user" :soldOffersCount="soldOffersCount" :rating="rating" :receivedRatings="receivedRatings"/>
        <BoldNormalText class="mt-4">
            <QuestionMarkCircleIcon class="w-5 h-5 inline-block align-text-bottom stroke-[2]" />
            {{ $t('help.want_to_rate') }}
        </BoldNormalText>
        <Divider class="md:w-full mt-4"/>
        <UserOffers :offers="activeOffers" class="py-4" v-if="activeOffers.length" :heading="$t('user.active_offers')"/>
        <UserOffers :offers="soldOffers" class="py-4" v-if="soldOffers.length" :heading="$t('user.sold_offers')"/>
        <NothingHere v-if="!activeOffers.length && !soldOffers.length" :text="$t('user.user_has_no_offers')">{{ $t('common.we_found_no_offers') }}</NothingHere>
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
import { Head } from '@inertiajs/vue3';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';
import { QuestionMarkCircleIcon } from '@heroicons/vue/24/outline';

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
        Inertia.visit(route('profile.show'));
    }
});
</script>