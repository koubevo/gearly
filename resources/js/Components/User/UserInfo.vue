<template>
    <section class="mb-2 flex gap-4 items-center">
        <Heading2 class="flex items-center gap-1">
            {{ user.name }}
            <VerifiedBadge v-if="user.gearly_verified" />
            <PremiumBadge v-if="user.is_premium" />
        </Heading2>
    </section>
    <section class="mb-4">
        <button @click="openModal" :disabled="receivedRatings.length === 0">
            <Rating :rating="rating" class="mb-1"/>
        </button>
        <SmallText v-if="soldOffersCount > 0" class="mb-1">{{ $t('common.already_sold_offers') }}: {{ soldOffersCount }}</SmallText>
        <TinyText class="mb-0.5">
            {{ user.location }}
            <span v-if="user.last_login_at"> | {{ $t('user.last_login') }} {{ user.last_login_at }}</span>
        </TinyText>
    </section>
    <Modal :show="modal" @close="closeModal" v-if="receivedRatings.length > 0">
        <div class="p-6">
          <div class="flex justify-between items-end">
            <Heading2>{{ $t('user.ratings') }}</Heading2>
            <button class="text-gray-700 hover:text-black" @click="closeModal">&times;</button>
          </div>        
          <Divider class="md:w-full my-4"/>
          <div class="flex flex-row gap-2 overflow-x-auto py-2">
            <div class="grid px-2 min-w-[250px] md:min-w-[300px]" v-for="receivedRating in receivedRatings" :key="receivedRating.id">
                <Rating :rating="receivedRating" class="mx-auto"/>
                <SmallText class="text-center my-1" v-if="receivedRating.comment">{{ receivedRating.comment }}</SmallText>
                <TinyText class="text-center">{{ receivedRating.created_at_formatted }}</TinyText>
            </div>
          </div>
        </div>
    </Modal>
</template>

<script setup>
import TinyText from '@/Components/Text/TinyText.vue'
import SmallText from '@/Components/Text/SmallText.vue'
import Rating from '@/Components/User/Rating.vue';
import Modal from "@/Components/Modal.vue";
import Divider from "@/Components/Search/Divider.vue";
import Heading2 from "@/Components/Text/Heading2.vue";
import { ref } from 'vue';
import VerifiedBadge from '@/Components/User/VerifiedBadge.vue';
import PremiumBadge from '@/Components/User/PremiumBadge.vue';

defineProps({
    user: Object,
    soldOffersCount: Number,
    rating: Object,
    receivedRatings: Array
})

const modal = ref(false);

const openModal = () => {
    modal.value = true;
};

const closeModal = () => {
    modal.value = false;
};
</script>