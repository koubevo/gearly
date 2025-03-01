<template>
    <section class="mb-2 flex gap-4 items-center">
        <!-- TODO: premium badge, verified badge -->
        <Heading1>{{ user.name }}</Heading1>
    </section>
    <section class="mb-4">
        <button @click="openModal" :disabled="receivedRatings.length === 0">
            <Rating :rating="rating" class="mb-1"/>
        </button>
        <SmallText v-if="soldOffersCount > 0" class="mb-1">Already sold items: {{ soldOffersCount }}</SmallText>
        <TinyText :text="user.location" class="mb-0.5"/>
    </section>
    <Modal :show="modal" @close="closeModal" v-if="receivedRatings.length > 0">
        <div class="p-6">
          <div class="flex justify-between items-end">
            <Heading2>Ratings</Heading2>
            <button class="text-gray-500 hover:text-black" @click="closeModal">&times;</button>
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
import Heading1 from '@/Components/Text/Heading1.vue'
import TinyText from '@/Components/Text/TinyText.vue'
import SmallText from '@/Components/Text/SmallText.vue'
import Rating from '@/Components/User/Rating.vue';
import Modal from "@/Components/Modal.vue";
import Divider from "@/Components/Search/Divider.vue";
import Heading2 from "@/Components/Text/Heading2.vue";
import { ref } from 'vue';

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